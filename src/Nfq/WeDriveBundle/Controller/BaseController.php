<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\WeDriveBundle\Constants\PassengerState;
use Nfq\WeDriveBundle\Entity\NotificationRepository;
use Nfq\WeDriveBundle\Entity\PassengerRepository;
use Nfq\WeDriveBundle\Entity\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        /** @var TripRepository $tripRepository */
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $tripList = $tripRepository->prepareTripList($this);

        return $this->render(
            'NfqWeDriveBundle:Default:index.html.twig',
            array(
                'availableTripList' => $tripList['available'],
                'joinedTripList' => $tripList['joined']
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

//    public function getNotificationList1()
//    {
//        $notificationList = array();
//        $requestList = array();
//        $messageList = array();
//
//        /** @var PassengerRepository $passengerRepository */
//        $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');
//
//        //check for messages and request for user as driver
//        $passengerList = $passengerRepository->getPassengersWithRequest($this->getUser());
//
//        foreach ($passengerList as $passenger) {
//            switch ($passenger->getAccepted()){
//                case PassengerState::ST_JOINED:
//                    $message = str_replace('##PASSENGER_NAME##',
//                        $passenger->getUser()->getUsername(),
//                        PassengerState::MSG_JOINED);
//                    $request = array(
//                        'message' => $message,
//                        'passengerId' => $passenger->getId());
//                    $requestList[] = $request;
//                    break;
//
//                case PassengerState::ST_CANCELED_BY_PASSENGER:
//                    $message = str_replace('##PASSENGER_NAME##',
//                        $passenger->getUser()->getUsername(),
//                        PassengerState::MSG_CANCELED_BY_PASSENGER);
//                    $msg = array(
//                        'message' => $message,
//                        'passengerId' => $passenger->getId());
//                    $messageList[] = $msg;
//                    break;
//            }
//        }
//
//        //check messages and request for user as passenger
//        $passengerList = $passengerRepository->getUserAsPassengerListWithRequest($this->getUser());
//
//        foreach ($passengerList as $passenger) {
//            switch ($passenger->getAccepted()){
//                case PassengerState::ST_CANCELED_BY_DRIVER:
//                    $message = str_replace('##DRIVER_NAME##',
//                        $passenger->getTrip()->getRoute()->getUser()->getUsername(),
//                        PassengerState::MSG_CANCELED_BY_DRIVER);
//                    $msg = array('message' => $message, 'passengerId' => $passenger->getId());
//                    $messageList[] = $msg;
//                    break;
//
//                case PassengerState::ST_REJECTED_BY_DRIVER:
//                    $message = str_replace('##DRIVER_NAME##',
//                        $passenger->getTrip()->getRoute()->getUser()->getUsername(),
//                        PassengerState::MSG_REJECTED_BY_DRIVER);
//                    $msg = array('message' => $message, 'passengerId' => $passenger->getId());
//                    $messageList[] = $msg;
//                    break;
//            }
//
//        }
//
//        $notificationList['requests'] = $requestList;
//
//        $notificationList['messages'] = $messageList;
//
//        $notificationList['count'] = count($notificationList['requests']) + count($notificationList['messages']);
//
//        return $notificationList;
//    }
}
