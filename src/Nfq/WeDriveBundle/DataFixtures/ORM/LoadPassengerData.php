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

class LoadPassengerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

               $passengers= array(
                   array('trip-1','accepted', 'user-11'),
                   array('trip-1','invited', 'user-12')
               );

                foreach($passengers as $passengerData){
                    $passenger = new Passenger();
                    $passenger->setUser($this->getReference($passengerData[2]));
                    $passenger->setTrip($this->getReference($passengerData[0]));
                    $passenger->setAccepted($passengerData[1]);

                    $manager->persist($passenger);
                }
                $manager->flush();
//*/
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}
