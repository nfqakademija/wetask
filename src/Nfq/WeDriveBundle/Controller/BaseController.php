<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction()
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $trips = $tripRepository->findAll();

        return $this->render('NfqWeDriveBundle:Base:base.html.twig', array('trips' => $trips));
    }
}
