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
//            array('route-4', strtotime('+0 hours 27 minutes'), 'My car is on 5A floor', 'trip-6', 2),
//            array('route-8', strtotime('+0 hours 40 minutes'), 'Priimu rukancius', 'trip-3', 3),
//            array('route-10', strtotime('+0 hours 50 minutes'), 'My car is on 5A floor', 'trip-5', 2),
//            array('route-7', strtotime('+1 hours 25 minutes'), 'I am listening Metallica', 'trip-9', 1),
//            array('route-1', strtotime('+1 hours 30 minutes'), 'Antakalnis', 'trip-1', 2),
//            array('route-2', strtotime('+1 hours 32 minutes'), 'Vairuosiu kruta masina', 'trip-2', 2),
//            array('route-5', strtotime('+3 hours 5 minutes'), 'I am on minivan today', 'trip-12', 6),
//            array('route-4', strtotime('+3 hours 20 minutes'), 'Only non smoking!', 'trip-10', 1),
//            array('route-9', strtotime('+3 hours 37 minutes'), 'My car is on 5A floor', 'trip-4', 1),
//            array('route-6', strtotime('+4 hours 12 minutes'), 'Imu suni', 'trip-7', 1),
//            array('route-1', strtotime('+4 hours 25 minutes'), 'No air conditioner', 'trip-8', 1),
//            array('route-4', strtotime('+24 hours 55 minutes'), 'Only non smoking!', 'trip-11', 3),
//            array('route-6', strtotime('+24 hours 15 minutes'), 'Radio not working', 'trip-13', 1),

            array('route-4', strtotime('+3 hours 27 minutes'), 'My car is on 5A floor', 'trip-6', 2),
            array('route-8', strtotime('+3 hours 40 minutes'), 'Priimu rukancius', 'trip-3', 3),
            array('route-10', strtotime('+3 hours 50 minutes'), 'My car is on 5A floor', 'trip-5', 2),
            array('route-7', strtotime('+4 hours 25 minutes'), 'I am listening Metallica', 'trip-9', 1),
            array('route-1', strtotime('+4 hours 30 minutes'), 'Antakalnis', 'trip-1', 2),
            array('route-2', strtotime('+4 hours 32 minutes'), 'Vairuosiu kruta masina', 'trip-2', 2),
            array('route-5', strtotime('+6 hours 5 minutes'), 'I am on minivan today', 'trip-12', 6),
            array('route-4', strtotime('+6 hours 20 minutes'), 'Only non smoking!', 'trip-10', 1),
            array('route-9', strtotime('+6 hours 37 minutes'), 'My car is on 5A floor', 'trip-4', 1),
            array('route-6', strtotime('+7 hours 12 minutes'), 'Imu suni', 'trip-7', 1),
            array('route-1', strtotime('+7 hours 25 minutes'), 'No air conditioner', 'trip-8', 1),
            array('route-4', strtotime('+27 hours 55 minutes'), 'Only non smoking!', 'trip-11', 3),
            array('route-6', strtotime('+27 hours 15 minutes'), 'Radio not working', 'trip-13', 1),

            array('route-4', strtotime('+8 hours 27 minutes'), 'My car is on 5A floor', 'trip-14', 2), //6
            array('route-8', strtotime('+8 hours 40 minutes'), 'Priimu rukancius', 'trip-15', 3),//3
            array('route-10', strtotime('+8 hours 50 minutes'), 'My car is on 5A floor', 'trip-16', 2),//5

            array('route-7', strtotime('+9 hours 25 minutes'), 'I am listening Metallica', 'trip-17', 1),//9
            array('route-1', strtotime('+9 hours 30 minutes'), 'Antakalnis', 'trip-18', 2),//1
            array('route-2', strtotime('+9 hours 32 minutes'), 'Vairuosiu kruta masina', 'trip-19', 2),//2

            array('route-5', strtotime('+12 hours 5 minutes'), 'I am on minivan today', 'trip-20', 6),//12
            array('route-4', strtotime('+12 hours 20 minutes'), 'Only non smoking!', 'trip-21', 1),//10
            array('route-9', strtotime('+12 hours 37 minutes'), 'My car is on 5A floor', 'trip-22', 1),//4

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
            $trip->setMaxPassengers($tripData[4]);

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
