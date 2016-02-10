<?php


namespace Nfq\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Nfq\WeDriveBundle\Entity\Notification;
use Nfq\WeDriveBundle\Entity\Passenger;
use Nfq\WeDriveBundle\Entity\Route;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection|Route[]
     *
     * @ORM\OneToMany(targetEntity="Nfq\WeDriveBundle\Entity\Route", mappedBy="user")
     */
    protected $routes;

    /**
     * @var ArrayCollection|Passenger[]
     *
     * @ORM\OneToMany(targetEntity="Nfq\WeDriveBundle\Entity\Passenger", mappedBy="user")
     */
    protected $passengers;

    /**
     * @var Invitation
     * @ORM\OneToOne(targetEntity="Nfq\UserBundle\Entity\Invitation", inversedBy="user")
     * @ORM\JoinColumn(referencedColumnName="code")
     */
    protected $invitation;

    /**
     * @var ArrayCollection|Notification[]
     *
     * @ORM\OneToMany(targetEntity="Nfq\WeDriveBundle\Entity\Notification", mappedBy="user")
     */
    private $notifications;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->routes = new ArrayCollection();
        $this->passengers = new ArrayCollection();
        $this->notifications =new ArrayCollection();
    }

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes->add($route);
    }

    /**
     * @param Route $route
     */
    public function removeRoute(Route $route)
    {
        $this->routes->removeElement($route);
    }

    /**
     * @param ArrayCollection|Route[] $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return ArrayCollection|Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }


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
     * Add passengers
     *
     * @param \Nfq\WeDriveBundle\Entity\Passenger $passengers
     * @return User
     */
    public function addPassenger(\Nfq\WeDriveBundle\Entity\Passenger $passengers)
    {
        $this->passengers[] = $passengers;

        return $this;
    }

    /**
     * Remove passengers
     *
     * @param \Nfq\WeDriveBundle\Entity\Passenger $passengers
     */
    public function removePassenger(\Nfq\WeDriveBundle\Entity\Passenger $passengers)
    {
        $this->passengers->removeElement($passengers);
    }

    /**
     * Get passengers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * @return \Nfq\UserBundle\Entity\Invitation
     */
    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * @param \Nfq\UserBundle\Entity\Invitation $invitation
     */
    public function setInvitation($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Add notifications
     *
     * @param \Nfq\WeDriveBundle\Entity\Notification $notifications
     * @return User
     */
    public function addNotification(\Nfq\WeDriveBundle\Entity\Notification $notifications)
    {
        $this->notifications[] = $notifications;

        return $this;
    }

    /**
     * Remove notifications
     *
     * @param \Nfq\WeDriveBundle\Entity\Notification $notifications
     */
    public function removeNotification(\Nfq\WeDriveBundle\Entity\Notification $notifications)
    {
        $this->notifications->removeElement($notifications);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
}
