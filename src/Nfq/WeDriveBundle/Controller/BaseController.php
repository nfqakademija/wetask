<?php

namespace Nfq\WeDriveBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Constants\PassengerState;
use Nfq\WeDriveBundle\Entity\Passenger;
use Nfq\WeDriveBundle\Entity\PassengerRepository;
use Nfq\WeDriveBundle\Entity\Trip;
use Nfq\WeDriveBundle\Entity\TripRepository;
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
        $tripsList = $this->getTripList();
        $time = 5;

        return $this->render(
            'NfqWeDriveBundle:Default:index.html.twig',
            array(
                'tripsList' => $tripsList,
                'time' => $time
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showNotificationsAction()
    {
        $notifications = $this->getNotificationList();

        return $this->render('NfqWeDriveBundle:Navbar:notifications.html.twig',
            array(
                'notifications' => $notifications,
            ));
    }

    public function getTripList()
    {
        /** @var TripRepository $tripRepository */
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');

        /** @var User $user */
        $user = $this->getUser();

        /** @var ArrayCollection|Trip[] $otherTrips */
        $otherTrips = $tripRepository->getOtherTrips($user);

        $elementType = array('danger', 'warning', 'success');
        $buttonNames = array('Join', 'Leave');
       // $buttonRoutes = array('nfq_wedrive_trip_join','nfq_wedrive_passenger_join_cancel');

        $tripList = array();

        foreach ($otherTrips as $trip) {

            $sCount = $tripRepository->getAvailableSeatsCount($trip);
            if ($sCount >= 0) {
                $buttonName = $buttonNames[0];
                $buttonUrl =$this->generateUrl(
                    'nfq_wedrive_trip_join',
                    array('tripId' => $trip->getId()));

                /** @var ArrayCollection|Passenger[] $passengers */
                $passengers = $tripRepository->getJoinedPassengersList($trip);

                foreach ($passengers as $passenger) {
                    if ($passenger->getUser() == $user) {
                        $buttonName = $buttonNames[1];
                        $buttonUrl =$this->generateUrl(
                            'nfq_wedrive_passenger_join_leave',
                            array('passengerId' => $passenger->getId()));
                        break;
                    }
                }

                if ($sCount != 0 || $buttonName == $buttonNames[1]) {

                    $tripRow['buttonName'] = $buttonName;
                    $tripRow['buttonUrl'] = $buttonUrl;
                    $tripRow['trip'] = $trip;
                    $tripRow['availableSeats']['count'] = $sCount;
                    if ($sCount > 2) {
                        $sCount = 2;
                    }
                    $tripRow['availableSeats']['type'] = $elementType[$sCount];

                    $tripRow['routePoints'] = $trip->getRoute()->getRoutePoints();

                    $tripList[] = $tripRow;
                }
            }
        }

        return $tripList;
    }


    public function getNotificationList()
    {
        $notificationList = array();
        $requestList = array();
        $messageList = array();

        /** @var PassengerRepository $passengerRepository */
        $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');

        //check for messages and request for user as driver
        $passengerList = $passengerRepository->getPassengersWithRequest($this->getUser());

        foreach ($passengerList as $passenger) {
            switch ($passenger->getAccepted()){
                case PassengerState::ST_JOINED:
                    $message = str_replace('##PASSENGER_NAME##',
                        $passenger->getUser()->getUsername(),
                        PassengerState::MSG_JOINED);
                    $request = array(
                        'message' => $message,
                        'passengerId' => $passenger->getId());
                    $requestList[] = $request;
                    break;

                case PassengerState::ST_CANCELED_BY_PASSENGER:
                    $message = str_replace('##PASSENGER_NAME##',
                        $passenger->getUser()->getUsername(),
                        PassengerState::MSG_CANCELED_BY_PASSENGER);
                    $msg = array(
                        'message' => $message,
                        'passengerId' => $passenger->getId());
                    $messageList[] = $msg;
                    break;
            }
        }

        //check messages and request for user as passenger
        $passengerList = $passengerRepository->getUserAsPassengerListWithRequest($this->getUser());

        foreach ($passengerList as $passenger) {
            switch ($passenger->getAccepted()){
                case PassengerState::ST_CANCELED_BY_DRIVER:
                    $message = str_replace('##DRIVER_NAME##',
                        $passenger->getTrip()->getRoute()->getUser()->getUsername(),
                        PassengerState::MSG_CANCELED_BY_DRIVER);
                    $msg = array('message' => $message, 'passengerId' => $passenger->getId());
                    $messageList[] = $msg;
                    break;

                case PassengerState::ST_REJECTED_BY_DRIVER:
                    $message = str_replace('##DRIVER_NAME##',
                        $passenger->getTrip()->getRoute()->getUser()->getUsername(),
                        PassengerState::MSG_REJECTED_BY_DRIVER);
                    $msg = array('message' => $message, 'passengerId' => $passenger->getId());
                    $messageList[] = $msg;
                    break;
            }

        }

        $notificationList['requests'] = $requestList;

        $notificationList['messages'] = $messageList;

        $notificationList['count'] = count($notificationList['requests']) + count($notificationList['messages']);

        return $notificationList;
    }
}
