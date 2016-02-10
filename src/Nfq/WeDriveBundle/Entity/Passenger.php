<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Trip;

/**
 * Passenger
 *
 * @ORM\Table(name = "passenger")
 * @ORM\Entity(repositoryClass="Nfq\WeDriveBundle\Entity\PassengerRepository")
 */
class Passenger
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
     * @ORM\ManyToOne(targetEntity="Trip", inversedBy="passengers")
     * @ORM\JoinColumn(name="trip_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $trip;

    /**
     * @var integer
     *
     * @ORM\Column(name="accepted", type="integer")
     */
    private $accepted;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Nfq\UserBundle\Entity\User", inversedBy="passengers")
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
     * Set trip
     *
     * @param Trip $trip
     * @return Passenger
     */
    public function setTrip($trip)
    {
        $this->trip = $trip;

        return $this;
    }

    /**
     * Get trip
     *
     * @return Trip
     */
    public function getTrip()
    {
        return $this->trip;
    }

    /**
     * Set accepted
     *
     * @param integer $accepted
     * @return Passenger
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return integer
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Passenger
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get userID
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
