<?php

namespace Vep\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller {
    public function indexAction() {
        $data = array(
            'production' => $this->getDoctrine()->getRepository('VepReservationBundle:Production')->findComing()
        );
        return $this->render('VepMainBundle:Main:index.html.twig', $data);
    }
}
