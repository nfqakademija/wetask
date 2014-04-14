<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\WeDriveBundle\Entity\Trip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nfq\WeDriveBundle\Form\Type\TripType;
use Symfony\Component\HttpFoundation\Request;


class TripController extends Controller
{
    public function listAction()
    {
        /** @var  $trips */
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $user = $this->getUser();
        $userTrips = $tripRepository->getTrips(0, $user);

        return $this->render(
            'NfqWeDriveBundle:Trip:list.html.twig',
            array('userTrips' => $userTrips, 'user' => $user)
        );
    }

    public function deleteAction($tripId)
    {
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $entityManager = $this->getDoctrine()->getManager();
    }

    public function newAction(Request $request)
    {
        $user = $this->getUser();

        $routes = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findBy(
            array('user' => $user->getId())
        );

        $trip = new Trip();
        $form = $this->createForm(new TripType($routes), $trip);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            var_dump($trip);
//            die();
            $em->persist($trip);
            $em->flush();
//
//            return $this->redirect($this->generateUrl('task_success'));
        }

        return $this->render(
            'NfqWeDriveBundle:Trip:new.html.twig',
            array(
                'user' => $user,
                'form' => $form->createView()
            )
        );
    }

}
