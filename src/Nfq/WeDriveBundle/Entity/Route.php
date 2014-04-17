<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Trip;

/**
 * Route
 *
 * @ORM\Table()
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
     * @ORM\Column(name="Destination", type="string", length=255)
     */
    private $destination;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Nfq\UserBundle\Entity\User", inversedBy="routes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;


    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
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
     * Set user
     *
     * @param User $user
     * @return Route
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trip = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trip
     *
     * @param Trip $trip
     * @return Route
     */
    public function addTrip(Trip $trip)
    {
        $this->trip[] = $trip;

        return $this;
    }

    /**
     * Remove trip
     *
     * @param Trip $trip
     */
    public function removeTrip(Trip $trip)
    {
        $this->trip->removeElement($trip);
    }

    /**
     * @return $this
     */
    public function unsetAllTrips()
    {
        foreach ($this->trips AS $trip)
        {
            unset($trip);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|Trip[]
     */
    public function getTrips()
    {
        return $this->trips;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection|Trip[] $trips
     */
    public function setTrips($trips)
    {
        $this->trips = $trips;
    }
}
