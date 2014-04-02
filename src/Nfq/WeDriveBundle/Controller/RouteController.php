<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RouteController extends Controller
{
    public function listAction()
    {
        $routes = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findAll();
        if (!$routes) {
            //Throw exeption
        }
        return $this->render('NfqWeDriveBundle:Route:list.html.twig', array('routes' => $routes));
    }
}
