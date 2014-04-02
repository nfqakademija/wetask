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

class LoadTripData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $trips= array(
            array('route-1', strtotime('+30 minutes'), 3, 'Antakalnis','trip-1',1),
            array('route-2', strtotime('+32 minutes'), 3, 'Vairuosiu kruta masina','trip-2',2),
            array('route-3', strtotime('+34 minutes'), 3, 'Priimu rukancius','trip-3',3),
            array('route-4', strtotime('+37 minutes'), 3, 'My car is on 5A floor','trip-4',1),
            array('route-5', strtotime('+50 minutes'), 3, 'My car is on 5A floor','trip-5',2),
            array('route-6', strtotime('+1350 minutes'), 3, 'My car is on 5A floor','trip-6',3),
        );

        foreach ($trips as $tripData) {
            /** @var Route $route */
            $route = $this->getReference($tripData[0]);

            $trip = new Trip();
            $trip->setRoute($route);
            $tmpDT= new \DateTime(date('Y-m-d H:i:s', $tripData[1]));
            $trip->setDepartTime($tmpDT);
            $trip->setMaxPassengers($tripData[2]);
            $trip->setDescription($tripData[3]);
            $trip->setTitle($route->getDestination());
            $trip->setAvailableSeats($tripData[5]);

            $manager->persist($trip);
            $this->addReference($tripData[4],$trip);
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
