<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RouteController extends Controller
{
    public function listAction()
    {
        $routes = array(1, 2, 3, 4);
        return $this->render('NfqWeDriveBundle:Route:list.html.twig', array('routes' => $routes));
    }
}
