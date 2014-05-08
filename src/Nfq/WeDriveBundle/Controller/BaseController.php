<?php

namespace Nfq\WeDriveBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Nfq\UserBundle\Entity\User;
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

        $notifications = $this->getNotificationList();

        return $this->render(
            'NfqWeDriveBundle:Default:index.html.twig',
            array(
                'tripsList' => $tripsList,
                'notifications' => $notifications,
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

        /** @var ArrayCollection|Trip[] $tripList */
        $tripList = array();

        foreach ($otherTrips as $trip) {

            $sCount = $trip->getAvailableSeats() - $tripRepository->getJoinedPassengersCount($trip);
            if ($sCount >= 0) {
                $buttonName = $buttonNames[0];

                foreach ($trip->getPassengers() as $passenger) {
                    if ($passenger->getUser() == $user) {
                        $buttonName = $buttonNames[1];
                        break;
                    }
                }

                if ($sCount != 0 || $buttonName == $buttonNames[1]) {

                    $tripRow['buttonName'] = $buttonName;
                    $tripRow['trip'] = $trip;
                    $tripRow['availableSeats']['count'] = $sCount;
                    if ($sCount > 2) {
                        $sCount = 2;
                    }
                    $tripRow['availableSeats']['type'] = $elementType[$sCount];
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

        /** @var PassengerRepository $passengerRepository */
        $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');

        $passengerList = $passengerRepository->getPassengersWithRequest($this->getUser());

        foreach ($passengerList as $passenger) {
            $message = $passenger->getUser()->getUsername() . ' wants to join you.';
            $request = array('message' => $message, 'passengerId' => $passenger->getId());
            $requestList[] = $request;
        }

        $messageList = array();
        $notificationList['requests'] = $requestList;

        $notificationList['messages'] = $messageList;

        $notificationList['count'] = count($notificationList['requests']) + count($notificationList['messages']);

        return $notificationList;
    }

}
