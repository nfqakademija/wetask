<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nfq\UserBundle\Entity\User;

/**
 * Passenger
 *
 * @ORM\Table()
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
     * @ORM\ManyToOne(targetEntity="Trip", inversedBy="passenger")
     * @ORM\Column()
     */
    private $trip;

    /**
     * @var integer
     *
     * @ORM\Column(name="Accepted", type="integer")
     */
    private $accepted;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\Column()
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
     * @param integer $trip
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
     * @return integer 
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
     * @param integer $user
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
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }
}
