<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction()
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $otherTrips = $tripRepository->getTrips(1);

        return $this->render(
            'NfqWeDriveBundle:Base:base.html.twig',
            array(
                'otherTrips' => $otherTrips,
                'userName' => 'Jonas',
                'buttonName' => 'Join',
                'buttonType' => 'success'
            )
        );
    }
}
