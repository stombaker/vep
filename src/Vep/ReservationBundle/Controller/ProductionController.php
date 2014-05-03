<?php

namespace Vep\ReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vep\ReservationBundle\Entity\Production;
use Vep\ReservationBundle\Entity\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductionController extends Controller {
    public function listAction() {
        $data = array(
            'list' => $this->getDoctrine()->getRepository('VepReservationBundle:Production')->findBy(array(), array('title' => 'asc'))
        );
        return $this->render('VepReservationBundle:Production:list.html.twig', $data);
    }
    
    public function readAction($id) {
        $production = $this->getDoctrine()->getRepository('VepReservationBundle:Production')->find($id);
        if ($production === null) {
            return $this->render('VepReservationBundle:Production:404.html.twig');
        } else {
            $data = array(
                'production' => $production
            );
            return $this->render('VepReservationBundle:Production:read.html.twig', $data);
        }
    }
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request) {
        $form = $this->createForm('form_production', new Production());
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $production = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($production);
                $em->flush();

                return $this->redirect($this->generateUrl('vep_reservation_production_read', array('id' => $production->getId())));
            }
        }

        $data = array(
            'form' => $form->createView()
        );
        return $this->render('VepReservationBundle:Production:create.html.twig', $data);
    }
    
    public function updateAction(Request $request, $id) {
        
    }
    
    public function deleteAction(Request $request, $id) {
        
    }
}
