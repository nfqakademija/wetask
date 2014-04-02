<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name = 'a')
    {
        return $this->render('NfqWeDriveBundle:Default:index.html.twig', array('name' => $name));
    }
}
