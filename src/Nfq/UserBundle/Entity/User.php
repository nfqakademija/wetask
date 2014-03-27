<?php


namespace Nfq\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Nfq\WeDriveBundle\Entity\Passenger;
use Nfq\WeDriveBundle\Entity\Route;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection|Route[]
     *
     * @ORM\OneToMany(targetEntity="Nfq\WeDriveBundle\Entity\Route", mappedBy="user")
     */
    protected $routes;

    /**
     * @var ArrayCollection|Passenger[]
     *
     * @ORM\OneToMany(targetEntity="Nfq\WeDriveBundle\Entity\Passenger", mappedBy="user")
     */
    protected $passengers;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->routes = new ArrayCollection();
    }

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes->add($route);
    }

    /**
     * @param Route $route
     */
    public function removeRoute(Route $route)
    {
        $this->routes->removeElement($route);
    }

    /**
     * @param ArrayCollection|Route[] $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return ArrayCollection|Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }


}