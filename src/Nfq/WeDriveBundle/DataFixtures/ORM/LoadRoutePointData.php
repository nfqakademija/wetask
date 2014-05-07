<?php
/**
 * Created by PhpStorm.
 * User: ITP
 * Date: 14.4.16
 * Time: 15.17
 */
namespace Nfq\WeDriveBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nfq\WeDriveBundle\Entity\Route;
use Nfq\WeDriveBundle\Entity\RoutePoint;

/**
 * Class LoadRoutePointData
 * Loads fixtures for Trip in defined order
 * @package Nfq\WeDriveBundle\DataFixtures\ORM
 */
class LoadRoutePointData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loads fixtures
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $points = array(
            array('route-1', 54.700804, 25.2218348, 1),
            array('route-1', 54.7097894, 25.1871227, 2),
            array('route-2', 54.6785165, 25.2674157, 1),
            array('route-2', 54.65076, 25.27209, 2),
            array('route-3', 54.65726, 25.24692, 1),
            array('route-4', 54.61224, 25.51471, 1),
            array('route-5', 54.00000, 24.54624, 1),
            array('route-6', 55.25687, 25.69426, 1),
            array('route-7', 54.84291, 26.31826, 1),
            array('route-8', 54.94324, 25.54266, 1),
            array('route-8', 53.4595667, 25.68438, 2),
            array('route-9', 53.5425667, 25.65321, 1),
            array('route-10', 54.995667, 25.78512, 1),
            array('route-10', 55.546237, 25.98543, 2),
            array('route-11', 54.459568, 25.48754, 1),
            array('route-12', 54.654667, 25.03566, 1),
            array('route-13', 53.655667, 25.78522, 1),
        );

        foreach ($points as $pointData) {
            /** @var Route $route */
            $route = $this->getReference($pointData[0]);

            $point = new RoutePoint();
            $point->setRoute($route);
            $point->setLatitude($pointData[1]);
            $point->setLongitude($pointData[2]);
            $point->setPOrder($pointData[3]);

            $manager->persist($point);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}
