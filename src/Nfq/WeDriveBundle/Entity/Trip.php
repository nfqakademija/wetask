<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Nfq\WeDriveBundle\Entity\Passenger;
use Nfq\WeDriveBundle\Entity\Route;

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
     * @ORM\ManyToOne(targetEntity="Nfq\WeDriveBundle\Entity\Route", inversedBy="trips", cascade = {"persist"})
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $route;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_time", type="datetime")
     */
    private $departureTime;

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
        $this->passengers = new ArrayCollection();
    }

    /**
     * Set route
     *
     * @param Route $route
     * @return Trip
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Add passenger
     *
     * @param Passenger $passenger
     * @return Trip
     */
    public function addPassenger(Passenger $passenger)
    {
        $this->passengers[] = $passenger;

        return $this;
    }

    /**
     * Remove passenger
     *
     * @param Passenger $passenger
     */
    public function removePassenger(Passenger $passenger)
    {
        $this->passengers->removeElement($passenger);
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
     * @return ArrayCollection|Passenger[]
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * @param ArrayCollection|Passenger[] $passengers
     */
    public function setPassengers($passengers)
    {
        $this->passengers = $passengers;
    }
}
