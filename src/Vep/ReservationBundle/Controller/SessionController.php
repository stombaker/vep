<?php

namespace Vep\ReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vep\ReservationBundle\Entity\Reservation;
use Vep\ReservationBundle\Form\ReservationType;

class SessionController extends Controller {
    public function listAction() {
        $data = array(
            'list' => $this->getDoctrine()->getRepository('VepReservationBundle:Session')->findBy(array(), array('date' => 'desc'))
        );
        return $this->render('VepReservationBundle:Session:list.html.twig', $data);
    }
    
    public function readAction(Request $request, $id) {
        $session = $this->getDoctrine()->getRepository('VepReservationBundle:Session')->find($id);
        if ($session === null) {
            return $this->render('VepReservationBundle:Session:404.html.twig');
        } else {
            $form = $this->createForm('form_reservation', new Reservation(), array('session' => $session));
            if ($request->getMethod() === 'POST') {
                $form->handleRequest($request);
                
                if ($form->isValid()) {
                    $reservation = $form->getData();
                    $reservation->setDate(new \Datetime());
                    $reservation->setSession($session);
                    
                    $session->addReservation($reservation);
                    
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($reservation);
                    $em->persist($session);
                    $em->flush();
                    
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Réservation sur le site de Voir & Entendre')
                        ->setFrom('contact@voir-entendre-posso.fr')
                        ->setTo($reservation->getEmail())
                        ->setBody(
                            $this->renderView(
                                'VepReservationBundle:Session:reserved.html.twig',
                                array('reservation' => $reservation)
                            )
                        );
                    $this->get('mailer')->send($message);
                    
                    $this->get('session')->getFlashBag()->add('success', 'Votre réservation a été effectuée. Vous allez recevoir un mail à l\'adresse que vous avez indiquée.');
                    return $this->redirect($this->generateUrl('vep_reservation_session_read', array('id' => $id)));
                }
            }
            
            $data = array(
                'session' => $session,
                'map' => $this->get('vep_reservation.theater')->getMapWithReservations($session),
                'form' => $form->createView()
            );
            return $this->render('VepReservationBundle:Session:read.html.twig', $data);
        }
    }
}
