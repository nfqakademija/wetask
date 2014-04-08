<?php

namespace Nfq\WeDriveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nfq\UserBundle\Entity\User;


class TripController extends Controller
{
    public function listAction()
    {
//        $time = 1000;
//        $trips = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip')
//            ->findAll();//findUpcomingTrips($time);
//        foreach ($trips as $trip) {
//            var_dump($trip);
//        }
//        die;

//        $entityManager = $this->getDoctrine()->getManager();
//        $userRepository = $this->getDoctrine()->getRepository('NfqUserBundle:User');
//        $user = $userRepository->findOneBy(array('username' => 'Jonas'));
//        $routes = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findOneBy(
//            array('user' => $user->getId())
//        );

//        $trips = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip')->
//            findBy(array('route' => $routes->getId()));

//        if (!$trips) {
//            throw $this->createNotFoundException(
//                'No trips found'
//            );
//        }

        /** @var  $trips */
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $userTrips = $tripRepository->getTrips(0);
        $otherTrips = $tripRepository->getTrips(1);

        return $this->render('NfqWeDriveBundle:Trip:list.html.twig',
                    array('userTrips' => $userTrips, 'otherTrips' => $otherTrips));
    }

    public function deleteAction($tripId)
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $entityManager = $this->getDoctrine()->getManager();
    }

}
