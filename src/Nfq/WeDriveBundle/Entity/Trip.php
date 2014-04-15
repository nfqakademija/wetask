<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trip
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nfq\WeDriveBundle\Entity\TripRepository")
 */
class Trip
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
     * @var Route
     *
     * @ORM\ManyToOne(targetEntity="Nfq\WeDriveBundle\Entity\Route", inversedBy="trip")
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", nullable=false)
     */
    private $route;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_time", type="datetime")
     */
    private $departureTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_passengers", type="integer")
     */
    private $maxPassengers;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var ArrayCollection|Passenger[]
     *
     * @ORM\OneToMany(targetEntity="Passenger", mappedBy="trip")
     */
    private $passengers;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="available_seats", type="integer")
     */
    private $availableSeats;

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
     * Set maxPassengers
     *
     * @param integer $maxPassengers
     * @return Trip
     */
    public function setMaxPassengers($maxPassengers)
    {
        $this->maxPassengers = $maxPassengers;

        return $this;
    }

    /**
     * Get maxPassengers
     *
     * @return integer
     */
    public function getMaxPassengers()
    {
        return $this->maxPassengers;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->passenger = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set route
     *
     * @param \Nfq\WeDriveBundle\Entity\Route $route
     * @return Trip
     */
    public function setRoute(\Nfq\WeDriveBundle\Entity\Route $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return \Nfq\WeDriveBundle\Entity\Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Add passenger
     *
     * @param \Nfq\WeDriveBundle\Entity\Passenger $passenger
     * @return Trip
     */
    public function addPassenger(\Nfq\WeDriveBundle\Entity\Passenger $passenger)
    {
        $this->passenger[] = $passenger;

        return $this;
    }

    /**
     * Remove passenger
     *
     * @param \Nfq\WeDriveBundle\Entity\Passenger $passenger
     */
    public function removePassenger(\Nfq\WeDriveBundle\Entity\Passenger $passenger)
    {
        $this->passenger->removeElement($passenger);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Trip
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getAvailableSeats()
    {
        return $this->availableSeats;
    }

    /**
     * @param int $availableSeats
     */
    public function setAvailableSeats($availableSeats)
    {
        $this->availableSeats = $availableSeats;
    }

    /**
     * @return \DateTime
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    /**
     * @param \DateTime $departureTime
     */
    public function setDepartureTime($departureTime)
    {
        $this->departureTime = $departureTime;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Nfq\WeDriveBundle\Entity\Passenger[]
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection|\Nfq\WeDriveBundle\Entity\Passenger[] $passengers
     */
    public function setPassengers($passengers)
    {
        $this->passengers = $passengers;
    }
}
