<?php

namespace Vep\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller {
    public function indexAction() {
        return $this->render('VepMainBundle:Default:index.html.twig');
    }
}
