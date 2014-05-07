<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\WeDriveBundle\Entity\PassengerRepository;
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
//        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
//        $user = $this->getUser();
//        $otherTrips = $tripRepository->getOtherTrips();


//        $elementType = array('danger', 'warning', 'success', 'success', 'success', 'success', 'success', 'success');
//        $buttonNames = array('Join', 'Waiting..', 'Joined', 'Rejected');



//        foreach ($otherTrips as $trip) {
//
//            $sCount = $trip->getAvailableSeats() - $tripRepository->getAcceptedPassengersCount($trip);
//            if ($sCount > 0)
//            {
//                $tripRow['trip'] = $trip;
//                $tripRow['availableSeats']['count'] = $sCount;
//                $tripRow['availableSeats']['type'] = $elementType[$sCount];
//
//
//                $buttonName = $buttonNames[0];
//
//                foreach ($trip->getPassengers() as $passenger) {
//                    if ($passenger->getUser() == $user) {
//                            $buttonName = $buttonNames[2];
//                    }
//                }
//
//                $tripRow['buttonName'] = $buttonName;
//                $tripsList[] = $tripRow;
//            }
//        }
        $tripsList = $this->getTripList();

//        $notifications = array();
//        $requestsList = array();

        /** @var PassengerRepository  $passengerRepository */
        $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');
        $passengers = $passengerRepository->getPassengersWithRequest($this->getUser());

        foreach ($passengers as $passenger) {
            $message = $passenger->getUser()->getUsername() . ' wants to join you.';
            $request = array('message' => $message, 'passengerId' => $passenger->getId());
            $requestsList[] = $request;
        }

        $notifications['requests'] = $requestsList;

        $messagesList = array(
            array(
                'message' => 'Jane accepted you request (test message)',
                'passengerId' => 1
            ),
            array(
                'message' => 'Peter rejected your request (test message)',
                'passengerId' => 3
            )
        );
        $notifications['messages'] = $messagesList;

        $notifications['count'] = count($notifications['requests']) + count($notifications['messages']);

        return $this->render(
            'NfqWeDriveBundle:Default:index.html.twig',
            array(
                'tripsList' => $tripsList,
                'notifications' => $notifications
            )
        );

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showMapAction()
    {
        return $this->render('NfqWeDriveBundle:Map:map.html.twig');
    }

    public function getTripList()
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $user = $this->getUser();
        $otherTrips = $tripRepository->getOtherTrips($user);

        $elementType = array('danger', 'warning', 'success', 'success', 'success', 'success', 'success', 'success');
        $buttonNames = array('Join', 'Waiting..', 'Joined', 'Rejected');

        $tripList = array();

        foreach ($otherTrips as $trip) {

            $sCount = $trip->getAvailableSeats() - $tripRepository->getAcceptedPassengersCount($trip);
            if ($sCount > 0)
            {
                $tripRow['trip'] = $trip;
                $tripRow['availableSeats']['count'] = $sCount;
                $tripRow['availableSeats']['type'] = $elementType[$sCount];


                $buttonName = $buttonNames[0];

                foreach ($trip->getPassengers() as $passenger) {
                    if ($passenger->getUser() == $user) {
                        $buttonName = $buttonNames[2];
                    }
                }

                $tripRow['buttonName'] = $buttonName;
                $tripList[] = $tripRow;
            }
        }

        return $tripList;

    }

    public function getNotificationList()
    {
        $notifications = array();
        $requestsList = array();

        $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');



    }


}
