<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Constants\PassengerState;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * TripRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TripRepository extends EntityRepository
{


    /**
     * @param User $user
     * @param int $hoursInterval
     * @return array
     */
    public function getUserTrips(User $user)
    {
        //prepare time for query
        $fromDate = date("Y-m-d H:i:s");

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            "
                            SELECT t
                            FROM Nfq\WeDriveBundle\Entity\Trip t
                            JOIN t.route r
                            WHERE r.user = :userId
                            AND t.departureTime > :departureTime
                            ORDER BY t.departureTime ASC
                        "
        )->setParameters(
                array(
                    'userId' => $user->getId(),
                    'departureTime' => $fromDate
                )
            );

        $trips = $query->getResult();

        if (!$trips) {
//            throw $this->createNotFoundException(
//                'No trips found'
//            );
        }

        return $trips;
    }

    /**
     * getOtherTrips
     *
     * @param User $user
     * @param int $hoursInterval
     * @return ArrayCollection|Trip[]
     */
    public function getOtherTrips(User $user, $hoursInterval = 5)
    {
        //prepare time for query
        $fromDate = date("Y-m-d H:i:s");
        $toDate = date("Y-m-d H:i:s", strtotime("+{$hoursInterval} hours"));

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            "
                            SELECT t
                            FROM Nfq\WeDriveBundle\Entity\Trip t
                            JOIN t.route r
                            WHERE r.user != :userId
                            AND t.departureTime > :departureTime
                            AND t.departureTime < :toDate
                            ORDER BY t.departureTime
                        "
        )->setParameters(
                array(
                    'userId' => $user->getId(),
                    'departureTime' => $fromDate,
                    'toDate' => $toDate
                )
            );

        $trips = $query->getResult();
//        if (!$trips) {
//            throw $this->createNotFoundException(
//                'No trips found'
//            );
//        }

        return $trips;
    }

    /**
     * getJoinedPassengersCount
     *
     * @param Trip trip
     * @return integer
     */
    public function getJoinedPassengersCount(Trip $trip)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            "
                            SELECT count(p)
                            FROM Nfq\WeDriveBundle\Entity\Passenger p
                            JOIN p.trip t
                            WHERE t.id = :tripId and
                            (p.accepted = :state1 or p.accepted = :state2)
                        "
        )->setParameters(
                array(
                    'tripId' => $trip->getId(),
                    'state1' => PassengerState::ST_JOINED,
                    'state2' => PassengerState::ST_JOINED_DRIVER_ACCEPTED
                )
            );

        $pCount = $query->getSingleScalarResult();

        return $pCount;
    }

    /**
     * getAvailableSeatsCount
     *
     * @param Trip trip
     * @return integer
     */
    public function getAvailableSeatsCount(Trip $trip)
    {
        return $trip->getMaxPassengers() - $this->getJoinedPassengersCount($trip);
    }

    /**
     * getJoinedPassengersList
     *
     * @param Trip trip
     * @return ArrayCollection|Passengers[]
     */
    public function getJoinedPassengersList($trip)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            "
                            SELECT p
                            FROM Nfq\WeDriveBundle\Entity\Passenger p
                            WHERE p.trip = :tripId and
                            (p.accepted = :state1 or p.accepted = :state2)
                        "
        )->setParameters(
                array(
                    'tripId' => $trip->getId(),
                    'state1' => PassengerState::ST_JOINED,
                    'state2' => PassengerState::ST_JOINED_DRIVER_ACCEPTED
                )
            );

        $passengers = $query->getResult();

        return $passengers;
    }

    /**
     * @param Controller $object
     * @return ArrayCollection
     */
    public function prepareTripList(Controller $object)
    {
        /** @var TripRepository $tripRepository */
//        $tripRepository = $object->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');

        /** @var User $user */
        $user = $object->getUser();

        /** @var ArrayCollection|Trip[] $otherTrips */
        $otherTrips = $this->getOtherTrips($user);

        $elementType = array('danger', 'warning', 'success');
        $buttonNames = array('Join', 'Leave');

        $tripList['available'] = array();
        $tripList['joined'] = array();

        foreach ($otherTrips as $trip) {

            $sCount = $this->getAvailableSeatsCount($trip);
            if ($sCount >= 0) {
                $buttonName = $buttonNames[0];
                $buttonUrl = $object->generateUrl(
                    'nfq_wedrive_ajax_trip_join',
                    array('tripId' => $trip->getId())
                );

                /** @var ArrayCollection|Passenger[] $passengers */
                $passengers = $this->getJoinedPassengersList($trip);

                foreach ($passengers as $passenger) {
                    if ($passenger->getUser() == $user) {
                        $buttonName = $buttonNames[1];
                        $buttonUrl = $object->generateUrl(
                            'nfq_wedrive_passenger_join_leave',
                            array('passengerId' => $passenger->getId())
                        );
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
                    if ($buttonName == $buttonNames[1]) {
                        $tripRow['availableSeats']['type'] = $elementType[1];
                    } else {
                        $tripRow['availableSeats']['type'] = $elementType[$sCount];
                    }

                    $tripRow['routePoints'] = $trip->getRoute()->getRoutePoints();

                    $tripList['available'][] = $tripRow;

                    if ($tripRow['buttonName'] == $buttonNames[1]) {
                        $tripList['joined'][] = $tripRow;
                    }
                }
            }
        }
        return $tripList;
    }


}
