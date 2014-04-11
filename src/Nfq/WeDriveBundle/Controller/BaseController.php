<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction()
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $user = $this->container->get('security.context')->getToken()->getUser();
        $otherTrips = $tripRepository->getTrips(1, $user);

        return $this->render(
            'NfqWeDriveBundle:Base:base.html.twig',
            array(
                'otherTrips' => $otherTrips,
                'user' => $user,
                'buttonName' => 'Join',
                'buttonType' => 'success'
            )
        );
    }
}
