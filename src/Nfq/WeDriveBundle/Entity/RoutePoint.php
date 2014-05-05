<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nfq\WeDriveBundle\Entity\Route;

/**
 * RoutePoint
 *
 * @ORM\Table(name = "route_point")
 * @ORM\Entity(repositoryClass="Nfq\WeDriveBundle\Entity\RoutePointRepository")
 */
class RoutePoint
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
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=7)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=7)
     */
    private $longitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="pOrder", type="integer")
     */
    private $pOrder;

    /**
     * @var Route
     *
     * @ORM\ManyToOne(targetEntity="Nfq\WeDriveBundle\Entity\Route", inversedBy="routePoints")
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", nullable=false)
     */
    private $route;




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
     * Set latitude
     *
     * @param string $latitude
     * @return RoutePoint
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return RoutePoint
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set pOrder
     *
     * @param integer $pOrder
     * @return RoutePoint
     */
    public function setPOrder($pOrder)
    {
        $this->pOrder = $pOrder;

        return $this;
    }

    /**
     * Get pOrder
     *
     * @return integer
     */
    public function getPOrder()
    {
        return $this->pOrder;
    }

    /**
     * Set route
     *
     * @param \Nfq\WeDriveBundle\Entity\Route $route
     * @return RoutePoint
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
}
