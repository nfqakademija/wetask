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
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $user = $this->getUser();
        $otherTrips = $tripRepository->getOtherTrips($user);

        $tripsList = array();
        $elementType = array('danger', 'warning', 'success', 'success', 'success', 'success', 'success', 'success');
        $buttonNames = array('Join', 'Waiting..', 'Joined', 'Rejected');

        foreach ($otherTrips as $trip) {
            $tripRow['trip'] = $trip;

            $sCount = $trip->getAvailableSeats() - $tripRepository->getAcceptedPassengersCount($trip);
            $tripRow['availableSeats']['count'] = $sCount;

            if ($sCount >= 0) {
                $tripRow['availableSeats']['type'] = $elementType[$sCount];
            } else {
                $tripRow['availableSeats']['type'] = $elementType[0];
            }

            $buttonName = $buttonNames[0];
            if ($sCount <= 0) {
                $buttonName = "No seats";
                $tripRow['buttonDisabled'] = true;
            } else {
                $tripRow['buttonDisabled'] = false;
            }
            foreach ($trip->getPassengers() as $passenger) {
                if ($passenger->getUser()->getUsername() == $user->getUsername()) {
                    if ($passenger->getAccepted() >= 0 && $passenger->getAccepted() < 3) {
                        $buttonName = $buttonNames[$passenger->getAccepted()];
                    }
                }
            }
            $tripRow['buttonName'] = $buttonName;

            $tripsList[] = $tripRow;
        }

        $notifications = array();
        $requestsList = array();

        /** @var PassengerRepository  $passengerRepository */
        $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');
        $passengers = $passengerRepository->getPassengersWithRequest($user);

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

}
