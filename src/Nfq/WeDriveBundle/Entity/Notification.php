<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nfq\WeDriveBundle\Entity\Passenger;

/**
 * Notification
 *
 * @ORM\Table(name = "notifications")
 * @ORM\Entity(repositoryClass="Nfq\WeDriveBundle\Entity\NotificationRepository")
 */
class Notification
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
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validTill", type="datetime")
     */
    private $validTill;

    /**
     * @var boolean
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen;

    /**
     * @var Passenger
     * @ORM\ManyToOne(targetEntity="Nfq\UserBundle\Entity\User", inversedBy="notifications")
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
     * Set message
     *
     * @param string $message
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set validTill
     *
     * @param \DateTime $validTill
     * @return Notification
     */
    public function setValidTill($validTill)
    {
        $this->validTill = $validTill;

        return $this;
    }

    /**
     * Get validTill
     *
     * @return \DateTime 
     */
    public function getValidTill()
    {
        return $this->validTill;
    }

    /**
     * Set seen
     *
     * @param boolean $seen
     * @return Notification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return boolean 
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set user
     *
     * @param \Nfq\UserBundle\Entity\User $user
     * @return Notification
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
