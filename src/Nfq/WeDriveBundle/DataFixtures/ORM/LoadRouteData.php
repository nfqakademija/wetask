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

/**
 * Class LoadRouteData
 * Loads fixtures for Route in defined order
 * @package Nfq\WeDriveBundle\DataFixtures\ORM
 */
class LoadRouteData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loads fixtures
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $routes = array(
            array('Antakalnis', 'user-1', 'route-1', 'Home'),
            array('Zirmunai', 'user-1', 'route-3', 'Home'),
            array('Antakalnis', 'user-2', 'route-2', 'Work'),
            array('Lazdynai', 'user-2', 'route-8', 'Pet store'),
            array('Kalnenai', 'user-2', 'route-9', 'Park'),
            array('Fabijoniskes', 'user-2', 'route-10', 'Perverted forest'),
            array('Naujamestis', 'user-3', 'route-4', 'Work'),
            array('Pilaite', 'user-8', 'route-5', 'Party'),
            array('Jeruzale', 'user-6', 'route-6', 'Hotel'),
            array('Lazdynai', 'user-4', 'route-7', 'Friends house'),
            array('Fabijoniskes', 'user-7', 'route-11', 'Shrub exhibition'),
            array('Virsuliskes', 'user-9', 'route-12', 'Glass room'),
            array('Karoliniskes', 'user-10', 'route-13', 'Home')
        );

        foreach ($routes as $routeData) {
            $route = new Route();
            $route->setDestination($routeData[0]);
            $route->setUser($this->getReference($routeData[1]));
            $route->setName($routeData[3]);
            $manager->persist($route);
            $this->addReference($routeData[2], $route);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
