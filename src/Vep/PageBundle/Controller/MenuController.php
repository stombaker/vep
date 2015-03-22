<?php

namespace Vep\PageBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller{
    public function listAction() {
        $list = $this->getDoctrine()->getRepository('VepPageBundle:Page')->findForMenu();
        $data = array('list' => $list);
        return $this->render('VepPageBundle:Menu:list.html.twig', $data);
    }
}