<?php

namespace Nfq\WeDriveBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Constants\PassengerState;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends EntityRepository
{
    /**
     * sends message to User depending on Passenger state
     *
     * @param Passenger $passenger
     * @param string $message
     * @returns Notification
     */
    public function generateNotification(Passenger $passenger, $message = "")
    {

        $user = $passenger->getUser();
        if($message == ""){
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
        }

        if($message!=""){
            $notification = new Notification();
            $notification->setMessage($message);
            $notification->setUser($user);
            $notification->setValidTill($passenger->getTrip()->getDepartureTime());
            $notification->setSeen(false);
            return $notification;
        }
        return false;
    }

    /**
     * @param User $user
     * @param int $hoursInterval
     * @return array
     */
    public function getNotificationList(User $user, $hoursInterval = 5)
    {
        $notificationList = array();

        $fromDate = date("Y-m-d H:i:s");
        $toDate = date("Y-m-d H:i:s", strtotime("+{$hoursInterval} hours"));

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            "
                            SELECT n
                            FROM Nfq\WeDriveBundle\Entity\Notification n
                            WHERE n.user = :user_id
                            and n.seen = :state
                            and n.validTill >:fromDate
                            and n.validTill <:toDate
                            ORDER BY n.id"
        )->setParameters(
                array(
                    'user_id' => $user->getId(),
                    'fromDate' => $fromDate,
                    'toDate' => $toDate,
                    'state' => false
                )
            );

        /** @var ArrayCollection|Notification[] $notifications */
        $notifications = $query->getResult();

        foreach ($notifications as $notification ){
            $msg = array('message' => $notification->getMessage(), 'notificationId' => $notification->getId());
            $notificationList[] = $msg;
        }

        return $notificationList;
    }
}
