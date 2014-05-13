<?php
/**
 * Created by PhpStorm.
 * User: ITP
 * Date: 14.4.1
 * Time: 10.17
 */
namespace Nfq\WeDriveBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nfq\WeDriveBundle\Entity\Passenger;
use Nfq\WeDriveBundle\Constants\PassengerState;

/**
 * Class LoadPassengerData
 * Loads fixtures for Passenger in defined order
 *
 * @package Nfq\WeDriveBundle\DataFixtures\ORM
 */
class LoadPassengerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loads fixtures
     *
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $passengers = array(
            array('trip-1', PassengerState::ST_JOINED, 'user-11'),
            array('trip-2', PassengerState::ST_JOINED, 'user-5'),
            array('trip-3', PassengerState::ST_JOINED_DRIVER_ACCEPTED, 'user-10'),
            array('trip-4', PassengerState::ST_JOINED, 'user-11'),
            array('trip-5', PassengerState::ST_JOINED, 'user-7'),
            array('trip-10', PassengerState::ST_JOINED, 'user-8'),
            array('trip-7', PassengerState::ST_JOINED, 'user-12'),
            array('trip-11', PassengerState::ST_JOINED, 'user-2'),
            array('trip-8', PassengerState::ST_JOINED, 'user-5'),
            array('trip-9', PassengerState::ST_JOINED, 'user-9'),
            array('trip-12', PassengerState::ST_JOINED, 'user-13'),
            array('trip-12', PassengerState::ST_JOINED, 'user-14'),
            array('trip-12', PassengerState::ST_JOINED, 'user-15'),
            array('trip-3', PassengerState::ST_CANCELED_BY_PASSENGER, 'user-15'),
            array('trip-12', PassengerState::ST_CANCELED_BY_DRIVER, 'user-18'),
            array('trip-12', PassengerState::ST_JOINED, 'user-16')
//        ,
//
//            array('trip-15', PassengerState::ST_JOINED_DRIVER_ACCEPTED, 'user-10'),
//            array('trip-15', PassengerState::ST_CANCELED_BY_PASSENGER, 'user-15'),
//            array('trip-16', PassengerState::ST_JOINED, 'user-7'),
//            array('trip-17', PassengerState::ST_JOINED, 'user-9'),
//            array('trip-18', PassengerState::ST_JOINED, 'user-11'),
//            array('trip-19', PassengerState::ST_JOINED, 'user-5'),
//
//            array('trip-20', PassengerState::ST_JOINED, 'user-13'),
//            array('trip-20', PassengerState::ST_JOINED, 'user-14'),
//            array('trip-20', PassengerState::ST_JOINED, 'user-15'),
//            array('trip-20', PassengerState::ST_CANCELED_BY_DRIVER, 'user-18'),
//            array('trip-20', PassengerState::ST_JOINED, 'user-16'),
//
//            array('trip-21', PassengerState::ST_JOINED, 'user-8'),
//            array('trip-22', PassengerState::ST_JOINED, 'user-11')
//

        );

        foreach ($passengers as $passengerData) {
            $passenger = new Passenger();
            $passenger->setTrip($this->getReference($passengerData[0]));
            $passenger->setAccepted($passengerData[1]);

            $manager->persist($passenger);
            $passenger->setUser($this->getReference($passengerData[2]));
        }
        $manager->flush();
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}
