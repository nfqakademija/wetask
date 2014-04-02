<?php

namespace Nfq\WeDriveBundle\Controller;

use Proxies\__CG__\Nfq\WeDriveBundle\Entity\Trip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TripController extends Controller
{
    public function listAction()
    {
        /*$trips = array(
            array(
            ),
            array(),
            array(),
            array(),
            array(),
            array()
        );*/

        $trips = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip')
            ->findAll();
//        foreach ($trips as $trip) {
//            var_dump($trip);
//        }
//        die;


        if (!$trips) {
            throw $this->createNotFoundException(
                'No trips found'
            );
        }

        return $this->render('NfqWeDriveBundle:Trip:list.html.twig', array('trips' => $trips));
    }
}
