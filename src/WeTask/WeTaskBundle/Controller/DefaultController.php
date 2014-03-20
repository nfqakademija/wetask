<?php

namespace WeTask\WeTaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WeTaskWeTaskBundle:Default:index.html.twig', array('name' => $name));
    }
}
