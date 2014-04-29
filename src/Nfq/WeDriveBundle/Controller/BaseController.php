<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Shows main window
 *
 * Class BaseController
 * @package Nfq\WeDriveBundle\Controller
 */
class BaseController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $user = $this->container->get('security.context')->getToken()->getUser();
        $otherTrips = $tripRepository->getOtherTrips($user);

        $tripsList = array();
        $elementType = array('danger','warning','success','success','success','success','success','success');
        $buttonNames = array('Join', 'Waiting..', 'Joined' );

        foreach ($otherTrips as $trip) {
            $tripRow['trip'] = $trip;

            $sCount =$trip->getAvailableSeats() - count($trip->getPassengers());
            $tripRow['availableSeats']['count'] =  $sCount;

            if($sCount >= 0) $tripRow['availableSeats']['type'] = $elementType[$sCount];
            else $tripRow['availableSeats']['type'] = $elementType[0];

            $buttonName = $buttonNames[0];
            if($sCount == 0) $buttonName = "No seats";
            foreach ($trip->getPassengers() as $passenger) {
                if ($passenger->getUser()->getUsername() == $user->getUsername())
                {
                    if($passenger->getAccepted() >= 0 && $passenger->getAccepted() <3)
                        $buttonName = $buttonNames[$passenger->getAccepted()];
                }
            }
            $tripRow['buttonName'] =  $buttonName;

            $tripsList[] = $tripRow;
        }


        return $this->render(
            'NfqWeDriveBundle:Default:index.html.twig',
            array(
                'tripsList' => $tripsList
            )
        );

//        return $this->render(
//            'NfqWeDriveBundle:Default:index.html.twig',
//            array(
//                'otherTrips' => $otherTrips,
//                'buttonName' => 'Join',
//                'buttonType' => 'success'
//            )
//        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showMapAction()
    {
        return $this->render('NfqWeDriveBundle:Map:map.html.twig');
    }

}
