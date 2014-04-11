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
        $user = $this->container->get('security.context')->getToken()->getUser();
        $userTrips = $tripRepository->getTrips(0, $user);

        return $this->render('NfqWeDriveBundle:Trip:list.html.twig',
                    array('userTrips' => $userTrips, 'user' => $user));
    }

    public function deleteAction($tripId)
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $entityManager = $this->getDoctrine()->getManager();
    }

    public function newAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('NfqWeDriveBundle:Trip:new.html.twig', array('user' => $user));
    }

}
