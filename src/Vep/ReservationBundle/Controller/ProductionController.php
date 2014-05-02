<?php

namespace Vep\ReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vep\ReservationBundle\Entity\Production;

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
    
    public function createAction(Request $request) {
        
    }
    
    public function updateAction(Request $request, $id) {
        
    }
    
    public function deleteAction(Request $request, $id) {
        
    }
}
