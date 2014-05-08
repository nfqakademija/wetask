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
            array('trip-1', '2', 'user-11'),
            array('trip-2', '1', 'user-5'),
            array('trip-3', '2', 'user-10'),
            array('trip-4', '2', 'user-11'),
            array('trip-5', '1', 'user-7'),
            array('trip-10', '1', 'user-8'),
            array('trip-7', '1', 'user-12'),
            array('trip-11', '2', 'user-2'),
            array('trip-8', '2', 'user-5'),
            array('trip-9', '2', 'user-9'),
            array('trip-12', '2', 'user-13'),
            array('trip-12', '2', 'user-14'),
            array('trip-12', '2', 'user-15'),
            array('trip-12', '2', 'user-16')
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
