<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * RoutePointRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoutePointRepository extends EntityRepository
{
    /* Ax+By+C=0*/
    /**
     * Calculate A coof
     * @param $y2
     * @param $y1
     * @return float
     */
    private function fA($y2, $y1)
    {
        return ($y2-$y1)*(-1);
    }

    /**
     * @param $x2
     * @param $x1
     * @return float
     */
    private function fB($x2, $x1)
    {
        return ($x2-$x1);
    }

    /**
     * @param $x1
     * @param $x2
     * @param $y1
     * @param $y2
     * @return float
     */
    private function fC($x1,$x2, $y1,$y2)
    {
        return ($y2*$x1)-($y1*$x2);
    }

    /**
     * @param $point
     * @param $line
     * @return float
     */
    public function getDistanceToLine($point, $line)
    {
        $A = $this->fA($line['y2'],$line['y1']);
        $B = $this->fB($line['x2'],$line['x1']);
        $C = $this->fC($line['x1'],$line['x2'],$line['y1'],$line['y2']);
        $sqrt = sqrt($A*$A+$B*$B);
        if ($sqrt==0) $sqrt= 0.0000001;
        return abs($A*$point['x']+$B*$point['y']+$C)/$sqrt;
    }

    /**
     * @param ArrayCollection|RoutePoint[] $routePoints
     * @param $point
     * @param $startPoint
     * @return int
     */
    public function getDistanceToRoute( $routePoints, $point, $startPoint)
    {
        $d = 99999;
        $tempPoint = null;
        foreach ($routePoints as $routePoint){
            if(! is_null($tempPoint)){
                $tempD = $this->getDistanceToLine(
                    $point,
                    array(
                        'x1' => $tempPoint->getLatitude(),
                        'y1' => $tempPoint->getLongitude(),
                        'x2' => $routePoint->getLatitude(),
                        'y2' => $routePoint->getLongitude()
                    )
                );
                if($tempD<$d) $d=$tempD;
            } else{
                $tempD = $this->getDistanceToLine(
                    $point,
                    array(
                        'x1' => $startPoint['x'],
                        'y1' => $startPoint['y'],
                        'x2' => $routePoint->getLatitude(),
                        'y2' => $routePoint->getLongitude()
                    )
                );
                if($tempD<$d) $d=$tempD;
            }
            $tempPoint =$routePoint;
        }
        return $d;
    }
}

