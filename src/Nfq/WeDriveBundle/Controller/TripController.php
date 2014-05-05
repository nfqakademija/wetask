<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\WeDriveBundle\Entity\Passenger;
use Nfq\WeDriveBundle\Entity\Trip;
use Nfq\WeDriveBundle\Form\Type\TripRouteType;
use Proxies\__CG__\Nfq\WeDriveBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nfq\WeDriveBundle\Form\Type\TripType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TripController
 * Manage trip
 * Shows trip list
 *
 * @package Nfq\WeDriveBundle\Controller
 */
class TripController extends Controller
{
    /**
     * Returns Trips list
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        /** @var  $trips */
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $user = $this->getUser();
        $userTrips = $tripRepository->getUserTrips($user);

        return $this->render(
            'NfqWeDriveBundle:Trip:list.html.twig',
            array('userTrips' => $userTrips)
        );
    }

    /**
     * Deteles Trip by id
     *
     * @param $tripId
     */
    public function deleteAction($tripId)
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $entityManager = $this->getDoctrine()->getManager();
//        TODO:
    }

    /**
     *
     * @param Request $request
     * @param $routeId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newTripAction(Request $request, $routeId)
    {

        $route = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findOneBy(
            array('id' => $routeId)
        );

        $trip = new Trip();
        $trip->setDepartureTime(new \DateTime("+3 hours"));
        $form = $this->createForm(new TripType(), $trip);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trip->setRoute($route);
            $em->persist($trip);
            $em->flush();
            return $this->redirect($this->generateUrl('nfq_wedrive_trip_list'));
        }

        return $this->render(
            'NfqWeDriveBundle:Trip:newTrip.html.twig',
            array(
                'form' => $form->createView(),
                'routeName' => $route->getName()
            )
        );
    }

    public function newRouteTripAction(Request $request)
    {
        $trip = new Trip();
        $form = $this->createForm(new TripRouteType(), $trip);
        $form->remove('route.name');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trip->getRoute()->setUser($this->getUser());
            $trip->setTitle($trip->getRoute()->getDestination());
            $em->persist($trip);
            $em->flush();
            return $this->redirect($this->generateUrl('nfq_wedrive_trip_list'));
        }

        return $this->render(
            'NfqWeDriveBundle:Trip:newRouteTrip.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function manageTripAction(Request $request, $tripId)
    {
        $trip = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip')
            ->findOneBy(array('id' => $tripId));

        $form = $this->createForm(new TripType(), $trip);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trip);
            $em ->flush();
            return $this->redirect($this->generateUrl('nfq_wedrive_trip_list'));
        }

        return $this->render(
            'NfqWeDriveBundle:Trip:newTrip.html.twig',
            array(
                'form' => $form->createView(),
                'routeName' => $trip->getTitle()
            )
        );
    }

    public function joinTripAction(Request $request, $tripId) {
        $em = $this->getDoctrine()->getManager();
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');

        $trip = $tripRepository->findOneBy(array('id' => $tripId));

        $passenger = new Passenger();
        $user = $this->getUser();

        $passenger->setUser($user);
        $passenger->setTrip($trip);
        $passenger->setAccepted(1);



        $trip->addPassenger($passenger);

        $em->persist($passenger);
        $em->persist($trip);
        $em->flush();

        $request->getSession()->getFlashBag()->add('error',"Join successful");

        return $this->redirect($this->generateUrl('nfq_wedrive_base'));
    }

}
