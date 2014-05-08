<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\WeDriveBundle\Constants\PassengerState;
use Nfq\WeDriveBundle\Entity\Passenger;
use Nfq\WeDriveBundle\Entity\Trip;
use Proxies\__CG__\Nfq\WeDriveBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PassengerController
 * Manage Passengers
 *
 *
 * @package Nfq\WeDriveBundle\Controller
 */
class PassengerController extends Controller
{
    /**
     *
     * @param Request $request
     * @param Passenger $passengerId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function acceptPassengerAction(Request $request, $passengerId) {
        $this->setPassengerState($passengerId, PassengerState::ST_JOINED_DRIVER_ACCEPTED);
        return $this->redirect($this->generateUrl('nfq_wedrive_base'));
    }

    /**
     *
     * @param Request $request
     * @param Passenger $passengerId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function rejectPassengerAction(Request $request, $passengerId) {
        $this->setPassengerState($passengerId, PassengerState::ST_REJECTED_BY_DRIVER);
        return $this->redirect($this->generateUrl('nfq_wedrive_base'));
    }

    /**
     *
     * @param Passenger $passengerId
     * @param Integer $state
     */

    private function setPassengerState($passengerId, $state) {
        $em = $this->getDoctrine()->getManager();
        $passengerRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Passenger');
        $passenger = $passengerRepository->findOneBy(array('id' => $passengerId));

        $passenger->setAccepted($state);
        $em->persist($passenger);
        $em->flush();
    }
}
