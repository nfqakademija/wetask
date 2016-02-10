<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\WeDriveBundle\Entity\Notification;
use Nfq\WeDriveBundle\Entity\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotificationController
 * Manage Notifications
 *
 *
 * @package Nfq\WeDriveBundle\Controller
 */
class NotificationController extends Controller
{
    /**
     * @param Request $request
     * @param $notificationId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function seenAction(Request $request, $notificationId)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var NotificationRepository $notificationRepository */
        $notificationRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Notification');

        /** @var Notification $notification */
        $notification = $notificationRepository->findOneBy(array('id' => $notificationId));

        $notification->setSeen(true);
        $em->persist($notification);
        $em->flush();

        return new Response(json_encode("Notification seen"));
//        return $this->redirect($this->generateUrl('nfq_wedrive_base'));
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showNotificationListAction()
    {
        /** @var NotificationRepository $notificationRepository */
        $notificationRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Notification');

        $notifications['messages'] = $notificationRepository->getNotificationList($this->getUser());

        $notifications['count'] = count($notifications['messages']);

        return $this->render('NfqWeDriveBundle:Navbar:notifications.html.twig',
            array(
                'notifications' => $notifications,
            ));
    }
}
