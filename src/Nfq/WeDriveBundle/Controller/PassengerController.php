<?php

namespace Nfq\WeDriveBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Nfq\WeDriveBundle\Constants\PassengerState;
use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Notification;
use Nfq\WeDriveBundle\Entity\NotificationRepository;
use Nfq\WeDriveBundle\Entity\Passenger;
use Nfq\WeDriveBundle\Entity\PassengerRepository;
use Nfq\WeDriveBundle\Entity\Trip;
use Nfq\WeDriveBundle\Entity\TripRepository;
use Nfq\WeDriveBundle\Exception\TripException;
use Proxies\__CG__\Nfq\WeDriveBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PassengerController
 * Manage Passengers
 *
 *
 * @package Nfq\WeDriveBundle\Controller
 */
class PassengerController extends Controller
{
    /**
     *
     * @param integer $tripId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request, $tripId)
    {
        /** @var TripRepository $tripRepository */
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');

        /** @var Trip $trip */
        $trip = $tripRepository->findOneBy(array('id' => $tripId));
        try {
            if ($trip == null) throw new TripException("Trip does not exist!");
            $this->checkTripOwner($trip, $this->getUser());
            /** @var ArrayCollection|Passenger[] $passengers */
            $passengers = $tripRepository->getJoinedPassengersList($trip);

            if(count($passengers)){
                foreach ($passengers as $passenger) {
                    $passengerRow['name'] = $passenger->getUser()->getUsername();
                    $passengerRow['state'] = 'Joined';
                    $passengerRow['id'] = $passenger->getId();

                    $passengerList[] = $passengerRow;
                }

                return $this->render(
                    'NfqWeDriveBundle:Passenger:list.html.twig',
                    array('tripPassengers' =>$passengerList, 'trip' => $trip)
                );
            }

            return $this->redirect($this->generateUrl('nfq_wedrive_trip_list'));
        } catch (TripException $e) {
            $request->getSession()->getFlashBag()->add('error', $e->getMessage());
            return $this->redirect($this->generateUrl('nfq_wedrive_trip_list'));
        }
    }

    /**
     *
     * @param Request $request
     * @param Passenger $passengerId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function rejectPassengerAction(Request $request, $passengerId) {
        try {
            $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');
            /** @var Passenger $passenger */
            $passenger = $passengerRepository->findOneBy(array('id' => $passengerId));
            if ($passenger == null) throw new TripException("Passenger does not exist!");
            $this->checkTripOwner($passenger->getTrip(),$this->getUser());
            $this->setPassengerState($passengerId, PassengerState::ST_REJECTED_BY_DRIVER);
        } catch (TripException $e) {
            $request->getSession()->getFlashBag()->add('error', $e->getMessage());
        }
        return $this->redirect($this->generateUrl('nfq_wedrive_trip_list'));
    }

    /**
     *
     * @param Request $request
     * @param Passenger $passengerId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function leaveTripAction(Request $request, $passengerId) {
        try {
            $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');
            /** @var Passenger $passenger */
            $passenger = $passengerRepository->findOneBy(array('id' => $passengerId));
            if ($passenger == null) throw new TripException("Passenger does not exist!");
            $this->checkPassengerUser($passenger,$this->getUser());
            $this->setPassengerState($passengerId, PassengerState::ST_CANCELED_BY_PASSENGER);
        } catch (TripException $e) {
            $request->getSession()->getFlashBag()->add('error', $e->getMessage());
            return $this->redirect($this->generateUrl('nfq_wedrive_trip_list'));
        }

        if ($request->isXmlHttpRequest()) {
            return new Response(json_encode("Leave"));
        }
//        return $this->redirect($this->generateUrl('nfq_wedrive_trip_list'));
    }

    /**
     *
     * @param Passenger $passengerId
     * @param Integer $state
     */

    private function setPassengerState($passengerId, $state) {
        $em = $this->getDoctrine()->getManager();
        $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');
        /** @var Passenger $passenger */
        $passenger = $passengerRepository->findOneBy(array('id' => $passengerId));

        $passenger->setAccepted($state);
        $em->persist($passenger);

        /** @var NotificationRepository $notificationRepository */
        $notificationRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Notification');

        /** @var Notification $notification */
        $notification = $notificationRepository->generateNotification($passenger);
        $em->persist($notification);

        $em->flush();
    }

    /**
     * @param Trip $trip
     * @param User $user
     * @return bool
     * @throws \Nfq\WeDriveBundle\Exception\TripException
     */
    private function checkTripOwner(Trip $trip, User $user)
    {

        if (($trip->getRoute()->getUser()->getId() !== $user->getId())
        || !(in_array("ROLE_USER",$user->getRoles()))) {
            throw new TripException("You do not have permissions to do this action!");
        }
        return true;
    }

    private function checkPassengerUser(Passenger $passenger, User $user)
    {
        if (($passenger->getUser()->getId() !== $user->getId())
            || !(in_array("ROLE_USER",$user->getRoles()))) {
            throw new TripException("You do not have permissions to do this action!");
        }
        return true;
    }

}
