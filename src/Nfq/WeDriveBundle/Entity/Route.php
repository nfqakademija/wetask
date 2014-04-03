<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Nfq\UserBundle\Entity\User;

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
     * @ORM\OneToMany(targetEntity="Nfq\WeDriveBundle\Entity\Trip", mappedBy="route")`
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
     * Get id
     *
     * @return integer
     */

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

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
     * @param \Nfq\WeDriveBundle\Entity\Trip $trip
     * @return Route
     */
    public function addTrip(\Nfq\WeDriveBundle\Entity\Trip $trip)
    {
        $this->trip[] = $trip;

        return $this;
    }

    /**
     * Remove trip
     *
     * @param \Nfq\WeDriveBundle\Entity\Trip $trip
     */
    public function removeTrip(\Nfq\WeDriveBundle\Entity\Trip $trip)
    {
        $this->trip->removeElement($trip);
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
     * @return \Doctrine\Common\Collections\ArrayCollection|\Nfq\WeDriveBundle\Entity\Trip[]
     */
    public function getTrips()
    {
        return $this->trips;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection|\Nfq\WeDriveBundle\Entity\Trip[] $trips
     */
    public function setTrips($trips)
    {
        $this->trips = $trips;
    }
}
