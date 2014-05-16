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

        );
        $passengers = array();
        $tripCount = 13;
        $cicleCount = 2;

        for($i = 0; $i <$cicleCount; $i++){
            $tripND = $tripCount * $i;
            $passengers[] = array('trip-'.(1+$tripND), PassengerState::ST_JOINED, 'user-11');
            $passengers[] = array('trip-'.(2+$tripND), PassengerState::ST_JOINED, 'user-5');
            $passengers[] = array('trip-'.(3+$tripND), PassengerState::ST_JOINED_DRIVER_ACCEPTED, 'user-10');
            $passengers[] = array('trip-'.(4+$tripND), PassengerState::ST_JOINED, 'user-11');
            $passengers[] = array('trip-'.(5+$tripND), PassengerState::ST_JOINED, 'user-7');
            $passengers[] = array('trip-'.(10+$tripND), PassengerState::ST_JOINED, 'user-8');
            $passengers[] = array('trip-'.(7+$tripND), PassengerState::ST_JOINED, 'user-12');
            //$passengers[] = array('trip-'.(11+$tripND), PassengerState::ST_JOINED, 'user-2');
            $passengers[] = array('trip-'.(8+$tripND), PassengerState::ST_JOINED, 'user-5');
            $passengers[] = array('trip-'.(9+$tripND), PassengerState::ST_JOINED, 'user-9');
            $passengers[] = array('trip-'.(12+$tripND), PassengerState::ST_JOINED, 'user-13');
            $passengers[] = array('trip-'.(12+$tripND), PassengerState::ST_JOINED, 'user-14');
            $passengers[] = array('trip-'.(12+$tripND), PassengerState::ST_JOINED, 'user-15');
            $passengers[] = array('trip-'.(3+$tripND), PassengerState::ST_CANCELED_BY_PASSENGER, 'user-15');
            $passengers[] = array('trip-'.(12+$tripND), PassengerState::ST_CANCELED_BY_DRIVER, 'user-18');
            $passengers[] = array('trip-'.(12+$tripND), PassengerState::ST_JOINED, 'user-16');
        }
        
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
