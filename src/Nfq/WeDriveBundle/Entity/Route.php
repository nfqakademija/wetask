<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Trip;

/**
 * Route
 *
 * @ORM\Table(name = "route")
 * @ORM\Entity(repositoryClass="Nfq\WeDriveBundle\Entity\RouteRepository")
 */
class Route
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection|Trip[]
     *
     * @ORM\OneToMany(targetEntity="Nfq\WeDriveBundle\Entity\Trip", mappedBy="route", orphanRemoval=true)
     */
    private $trips;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255)
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var ArrayCollection|RoutePoint[]
     *
     * @ORM\OneToMany(targetEntity="Nfq\WeDriveBundle\Entity\RoutePoint", mappedBy="route", cascade={"remove"})`
     */
    private $routePoints;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Nfq\UserBundle\Entity\User", inversedBy="routes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trips = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routePoints = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set destination
     *
     * @param string $destination
     * @return Route
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Route
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add trips
     *
     * @param \Nfq\WeDriveBundle\Entity\Trip $trips
     * @return Route
     */
    public function addTrip(\Nfq\WeDriveBundle\Entity\Trip $trips)
    {
        $this->trips[] = $trips;

        return $this;
    }

    /**
     * Remove trips
     *
     * @param \Nfq\WeDriveBundle\Entity\Trip $trips
     */
    public function removeTrip(\Nfq\WeDriveBundle\Entity\Trip $trips)
    {
        $this->trips->removeElement($trips);
    }

    /**
     * Get trips
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTrips()
    {
        return $this->trips;
    }

    /**
     * Add routePoints
     *
     * @param \Nfq\WeDriveBundle\Entity\RoutePoint $routePoints
     * @return Route
     */
    public function addRoutePoint(\Nfq\WeDriveBundle\Entity\RoutePoint $routePoints)
    {
        $this->routePoints[] = $routePoints;

        return $this;
    }

    /**
     * Remove routePoints
     *
     * @param \Nfq\WeDriveBundle\Entity\RoutePoint $routePoints
     */
    public function removeRoutePoint(\Nfq\WeDriveBundle\Entity\RoutePoint $routePoints)
    {
        $this->routePoints->removeElement($routePoints);
    }

    /**
     * Get routePoints
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoutePoints()
    {
        return $this->routePoints;
    }

    /**
     * Set user
     *
     * @param \Nfq\UserBundle\Entity\User $user
     * @return Route
     */
    public function setUser(\Nfq\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Nfq\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
