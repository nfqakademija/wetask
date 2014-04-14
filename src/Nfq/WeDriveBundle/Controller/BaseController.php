<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction()
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $user = $this->container->get('security.context')->getToken()->getUser();
        $otherTrips = $tripRepository->getOtherTrips($user);

        return $this->render(
            'NfqWeDriveBundle:Default:index.html.twig',
            array(
                'otherTrips' => $otherTrips,
                'buttonName' => 'Join',
                'buttonType' => 'success'
            )
        );
    }

    public function showMapAction()
    {
        return $this->render('NfqWeDriveBundle:Map:map.html.twig');
    }

}
