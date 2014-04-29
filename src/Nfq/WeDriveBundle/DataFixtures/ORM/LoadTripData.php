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
use Nfq\WeDriveBundle\Entity\Route;
use Nfq\WeDriveBundle\Entity\Trip;

/**
 * Class LoadTripData
 * Loads fixtures for Trip in defined order
 * @package Nfq\WeDriveBundle\DataFixtures\ORM
 */
class LoadTripData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loads fixtures
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $trips = array(
            array('route-1', strtotime('+3 hours 30 minutes'), 'Antakalnis', 'trip-1', 1),
            array('route-2', strtotime('+3 hours 32 minutes'), 'Vairuosiu kruta masina', 'trip-2', 2),
            array('route-8', strtotime('+3 hours 34 minutes'), 'Priimu rukancius', 'trip-3', 3),
            array('route-9', strtotime('+3 hours 37 minutes'), 'My car is on 5A floor', 'trip-4', 1),
            array('route-10', strtotime('+3 hours 50 minutes'), 'My car is on 5A floor', 'trip-5', 2),
            array('route-4', strtotime('+3 hours 1350 minutes'), 'My car is on 5A floor', 'trip-6', 2),
            array('route-6', strtotime('+3 hours 12 minutes'), 'Imu suni', 'trip-7', 1),
            array('route-1', strtotime('+3 hours 25 minutes'), 'Nothing to see here', 'trip-8', 1),
            array('route-3', strtotime('+3 hours 25 minutes'), 'Nothing to see here', 'trip-9', 1),
            array('route-4', strtotime('+3 hours 5125 minutes'), 'Nothing to see here', 'trip-10', 1),
            array('route-4', strtotime('+3 hours 225 minutes'), 'Nothing to see here', 'trip-11', 2),
            array('route-5', strtotime('+3 hours 325 minutes'), 'Nothing to see here', 'trip-12', 1),
            array('route-6', strtotime('+3 hours 425 minutes'), 'Nothing to see here', 'trip-13', 1)
        );

        foreach ($trips as $tripData) {
            /** @var Route $route */
            $route = $this->getReference($tripData[0]);

            $trip = new Trip();
            $trip->setRoute($route);
            $tmpDT = new \DateTime(date('Y-m-d H:i:s', $tripData[1]));
            $trip->setDepartureTime($tmpDT);
            $trip->setDescription($tripData[2]);
            $trip->setTitle($route->getDestination());
            $trip->setAvailableSeats($tripData[4]);

            $manager->persist($trip);
            $this->addReference($tripData[3], $trip);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
