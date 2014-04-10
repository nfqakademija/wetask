<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Nfq\UserBundle\Entity\User;


class TestController extends Controller
{
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
//        %userName = $user->
        return new Response('<html><body>Hello World from test'.$user->getUsername().'!</body></html>');
    }
}
