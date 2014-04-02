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

class LoadRouteData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $routes = array(
            array('Antakalnis', 'user-1', 'route-1'),
            array('Antakalnis', 'user-2', 'route-2'),
            array('Zirmunai', 'user-1', 'route-3'),
            array('Naujamestis', 'user-3', 'route-4'),
            array('Pilaite', 'user-8', 'route-5'),
            array('Jeruzale', 'user-6', 'route-6'),
            array('Lazdynai', 'user-4', 'route-7'),
            array('Lazdynai', 'user-2', 'route-8'),
            array('Kalnenai', 'user-5', 'route-9'),
            array('Fabijoniskes', 'user-6', 'route-10'),
            array('Fabijoniskes', 'user-7', 'route-11'),
            array('Virsuliskes', 'user-9', 'route-12'),
            array('Karoliniskes', 'user-10', 'route-13')
        );

        foreach ($routes as $routeData) {
            $route = new Route();
            $route->setDestination($routeData[0]);
            $route->setUser($this->getReference($routeData[1]));
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
