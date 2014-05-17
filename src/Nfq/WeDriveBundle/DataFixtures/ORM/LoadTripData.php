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
        $trips = array();

        $everyHourCount = 5;
        //$tripsCount = 13;
        $cycleCount = 4; // $cycleCount * $everyHourCount +5 -is fixtures availability time

        for($i = 0; $i < $cycleCount; $i++){
            $timeDelta = $everyHourCount * $i;
            $delta = 100 * $i; //trip Number Delta
            $trips[] = array('route-4', strtotime('+'.$timeDelta.' hours 27 minutes'), 'My car is on 5A floor', 'trip-'.(6+$delta), 2);
            $trips[] = array('route-8', strtotime('+'.$timeDelta.' hours 40 minutes'), 'Priimu rukancius', 'trip-'.(3+$delta), 3);
            $trips[] = array('route-10', strtotime('+'.$timeDelta.' hours 50 minutes'), 'My car is on 5A floor', 'trip-'.(5+$delta), 2);
            $trips[] = array('route-7', strtotime('+'.(1+$timeDelta).' hours 25 minutes'), 'I am listening Metallica', 'trip-'.(9+$delta), 1);
            $trips[] = array('route-1', strtotime('+'.(1+$timeDelta).' hours 30 minutes'), 'Antakalnis', 'trip-'.(1+$delta), 2);
            $trips[] = array('route-2', strtotime('+'.(1+$timeDelta).' hours 32 minutes'), 'Vairuosiu kruta masina', 'trip-'.(2+$delta), 2);
            $trips[] = array('route-5', strtotime('+'.(3+$timeDelta).' hours 5 minutes'), 'I am on minivan today', 'trip-'.(12+$delta), 6);
            $trips[] = array('route-4', strtotime('+'.(3+$timeDelta).' hours 20 minutes'), 'Only non smoking!', 'trip-'.(10+$delta), 1);
            $trips[] = array('route-9', strtotime('+'.(3+$timeDelta).' hours 37 minutes'), 'My car is on 5A floor', 'trip-'.(4+$delta), 1);
            $trips[] = array('route-6', strtotime('+'.(4+$timeDelta).' hours 12 minutes'), 'Imu suni', 'trip-'.(7+$delta), 1);
            $trips[] = array('route-1', strtotime('+'.(4+$timeDelta).' hours 25 minutes'), 'No air conditioner', 'trip-'.(8+$delta), 1);
            //$trips[] = array('route-4', strtotime('+'.(25+$timeDelta).' hours 55 minutes'), 'Only non smoking!', 'trip-'.(11+$delta), 3);
            //$trips[] = array('route-6', strtotime('+'.(25+$timeDelta).' hours 15 minutes'), 'Radio not working', 'trip-'.(13+$delta), 1);

        }

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
