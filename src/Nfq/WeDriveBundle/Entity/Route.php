<?php

namespace Nfq\WeDriveBundle\Entity;

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
     * @var Trip
     *
     * @ORM\OneToMany(targetEntity="Trip", mappedBy="route")`
     */
    private $trip;


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
     * @param Trip $trip
     */
    public function setTrip(Trip $trip = null)
    {
        $this->trip = $trip;
    }

    /**
     * @return Trip
     */
    public function getTrip()
    {
        return $this->trip;
    }
}
