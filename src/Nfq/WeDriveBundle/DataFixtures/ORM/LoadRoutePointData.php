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
            array('route-1', 54.7228357, 25.2981234, 0),
            array('route-1', 54.7201093, 25.3212547, 1),
            array('route-2', 54.6851450, 25.2858925, 0),
            array('route-2', 54.7048874, 25.3115559, 1),
            array('route-3', 54.7116066, 25.3018785, 0),
            array('route-4', 54.6747739, 25.2639198, 0),
            array('route-5', 54.7096975, 25.1870370, 0),
            array('route-6', 54.7413211, 25.2711511, 0),
            array('route-7', 54.6743552, 25.2015799, 0),
            array('route-8', 54.7092265, 25.2277422, 0),
            array('route-8', 54.6829432, 25.2126682, 1),
            array('route-9', 54.6539369, 25.3388929, 0),
            array('route-10', 54.7398223, 25.2280855, 0),
            array('route-10', 54.7399152, 25.2352846, 1),
            array('route-10', 54.7410424, 25.2403700, 2),
            array('route-11', 54.4595680, 25.4875400, 0),
            array('route-12', 54.6546670, 25.0356600, 0),
            array('route-13', 54.6908008, 25.2069712, 0),
            array('route-14', 54.6931603, 25.2215302, 0),
        );

        foreach ($points as $pointData) {
            /** @var Route $route */
            $route = $this->getReference($pointData[0]);

            $point = new RoutePoint();
            $point->setRoute($route);
            $point->setLatitude($pointData[1]);
            $point->setLongitude($pointData[2]);
            $point->setPOrder($pointData[3]);

//            $manager->persist($point);
        }

//        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}
