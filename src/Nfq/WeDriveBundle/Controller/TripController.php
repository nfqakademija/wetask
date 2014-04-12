<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\WeDriveBundle\Entity\Trip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nfq\WeDriveBundle\Form\Type\TripType;


class TripController extends Controller
{
    public function listAction()
    {
        /** @var  $trips */
        $tripRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Trip');
        $user = $this->container->get('security.context')->getToken()->getUser();
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

    public function newAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $trip = new Trip();
        $form = $this->createForm(new TripType());

        return $this->render(
            'NfqWeDriveBundle:Trip:new.html.twig',
            array(
                'user' => $user,
                'form' => $form->createView()
            )
        );
    }
}
