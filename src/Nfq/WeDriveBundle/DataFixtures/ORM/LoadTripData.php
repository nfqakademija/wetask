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
use Nfq\WeDriveBundle\Entity\Trip;

class LoadTripData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $trips = array(
            array('route-1', '2014-04-30 16:45:00', 3, 'My car is on 5A floor', 'trip-1')
        );

        foreach ($trips as $tripData) {
            $trip = new Trip();
            $trip->setRoute($this->getReference($tripData[0]));
            $tmpDT = new \DateTime($tripData[1]);
            $trip->setDepartTime($tmpDT);
            $trip->setMaxPassengers($tripData[2]);
            $trip->setDescription($tripData[3]);

            $manager->persist($trip);
            $this->addReference($tripData[4], $trip);
        }
        $manager->flush(); //*/
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
