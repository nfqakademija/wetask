<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\WeDriveBundle\Entity\Trip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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

        return $this->render(
            'NfqWeDriveBundle:Trip:list.html.twig',
            array('userTrips' => $userTrips)
        );
    }

    public function deleteAction($tripId)
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $entityManager = $this->getDoctrine()->getManager();
    }

    public function newAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $trip = new Trip();
        $trip->setMaxPassengers(3);
        $form = $this->createFormBuilder($trip)
            ->add('Departure_time', 'text')
            ->add('Max_passengers', 'integer')
            ->add('Description', 'text')
            ->add('save', 'submit')
            ->getForm();

        return $this->render(
            'NfqWeDriveBundle:Trip:new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

}
