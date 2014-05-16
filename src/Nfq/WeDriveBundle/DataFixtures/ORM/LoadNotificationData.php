<?php
namespace Nfq\WeDriveBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nfq\WeDriveBundle\Constants\PassengerState;
use Nfq\WeDriveBundle\Entity\Notification;
use Nfq\WeDriveBundle\Entity\Passenger;

/**
 * Class LoadNotificationData
 * Loads fixtures for Notification in defined order
 * @package Nfq\WeDriveBundle\DataFixtures\ORM
 */
class LoadNotificationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loads fixtures
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $notifications = array();

        $cycleCount = 2; // $cycleCount * $everyHourCount +5 -is fixtures availability time

        for($i = 0; $i < $cycleCount; $i++){
            $delta = 100 * $i;
            $notifications[] = array('pass-'.(1+$delta));
            $notifications[] = array('pass-'.(2+$delta));
            $notifications[] = array('pass-'.(3+$delta));
            $notifications[] = array('pass-'.(4+$delta));
            $notifications[] = array('pass-'.(5+$delta));
            $notifications[] = array('pass-'.(6+$delta));
            $notifications[] = array('pass-'.(7+$delta));
            //$notifications[] = array('pass-'.(8+$delta));
            $notifications[] = array('pass-'.(9+$delta));
            $notifications[] = array('pass-'.(10+$delta));
            $notifications[] = array('pass-'.(11+$delta));
            $notifications[] = array('pass-'.(12+$delta));
            $notifications[] = array('pass-'.(13+$delta));
            $notifications[] = array('pass-'.(14+$delta));
            $notifications[] = array('pass-'.(15+$delta));
            $notifications[] = array('pass-'.(16+$delta));
        }

        $flushRequired = false;
        foreach ($notifications as $notificationData) {
            /** @var Passenger $passenger */
            $passenger = $this->getReference($notificationData[0]);

            $notification = new Notification();
            $message = "";
            $user = $passenger->getUser();
            switch ($passenger->getAccepted()) {
                case PassengerState::ST_JOINED:
                    $message = str_replace('##PASSENGER_NAME##',
                        $passenger->getUser()->getUsername(),
                        PassengerState::MSG_JOINED);
                    $user = $passenger->getTrip()->getRoute()->getUser();
                    break;

                case PassengerState::ST_CANCELED_BY_PASSENGER:
                    $message = str_replace('##PASSENGER_NAME##',
                        $passenger->getUser()->getUsername(),
                        PassengerState::MSG_CANCELED_BY_PASSENGER);
                    $user = $passenger->getTrip()->getRoute()->getUser();
                    break;

                case PassengerState::ST_CANCELED_BY_DRIVER:
                    $message = str_replace('##DRIVER_NAME##',
                        $passenger->getTrip()->getRoute()->getUser()->getUsername(),
                        PassengerState::MSG_CANCELED_BY_DRIVER);
                    break;

                case PassengerState::ST_REJECTED_BY_DRIVER:
                    $message = str_replace('##DRIVER_NAME##',
                        $passenger->getTrip()->getRoute()->getUser()->getUsername(),
                        PassengerState::MSG_REJECTED_BY_DRIVER);
                    break;
            }
            if($message!=""){
                $notification->setMessage($message);
                $notification->setUser($user);
                $notification->setValidTill($passenger->getTrip()->getDepartureTime());
                $notification->setSeen(false);
                $manager->persist($notification);
                $flushRequired = true;
            }
        }

        if ($flushRequired) $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
}
