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
            array('route-3', 43.4595667, -79.4033500, 1),
            array('route-4', 43.4595667, -79.4033500, 1),
            array('route-5', 43.4595667, -79.4033500, 1),
            array('route-6', 43.4595667, -79.4033500, 1),
            array('route-7', 43.4595667, -79.4033500, 1),
            array('route-8', 43.4595667, -79.4033500, 1),
            array('route-8', 43.4595667, -79.4033500, 2),
            array('route-9', 43.4595667, -79.4033500, 1),
            array('route-10', 43.4595667, -79.4033500, 1),
            array('route-10', 43.4595667, -79.4033500, 2),
            array('route-11', 43.4595667, -79.4033500, 1),
            array('route-12', 43.4595667, -79.4033500, 1),
            array('route-13', 43.4595667, -79.4033500, 1),
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
