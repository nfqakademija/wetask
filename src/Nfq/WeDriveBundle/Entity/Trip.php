<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\ManyToOne(targetEntity="Nfq\WeDriveBundle\Entity\Route", inversedBy="trip")
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", nullable=false)
     */
    private $route;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="depart_time", type="date")
     */
    private $departTime;

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
    private $passenger;


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
     * Set departTime
     *
     * @param \DateTime $departTime
     * @return Trip
     */
    public function setDepartTime($departTime)
    {
        $this->departTime = $departTime;

        return $this;
    }

    /**
     * Get departTime
     *
     * @return \DateTime 
     */
    public function getDepartTime()
    {
        return $this->departTime;
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
     * Set description
     *
     * @param string $description
     * @return Trip
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
     * Set passenger
     *
     * @param integer $passenger
     * @return Trip
     */
    public function setPassenger($passenger)
    {
        $this->passenger = $passenger;

        return $this;
    }

    /**
     * Get passenger
     *
     * @return integer 
     */
    public function getPassenger()
    {
        return $this->passenger;
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
}
