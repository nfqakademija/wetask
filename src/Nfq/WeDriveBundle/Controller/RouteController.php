<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RouteController
 * @package Nfq\WeDriveBundle\Controller
 */
class RouteController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $userRepository = $this->getDoctrine()->getRepository('NfqUserBundle:User');
        /** @var User $user */
        $user = $userRepository->findOneBy(array('username' => 'Jonas'));

        $routes = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findBy(array('user' => $user->getId()));
        if (!$routes) {
            //Throw exception
        }
        return $this->render('NfqWeDriveBundle:Route:list.html.twig', array('routes' => $routes));
    }

    /**
     * @param $routeId
     */
    public function deleteAction($routeId)
    {
        $routeRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route');
        $userRepository = $this->getDoctrine()->getRepository('NfqUserBundle:User');
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Route $route */
        $route = $routeRepository->findOneBy(array('id' => $routeId));

        /** @var User $user */
        $user = $userRepository->findOneBy(array('username' => 'Jonas'));

        if (canDelete($route,$user)) {
            //return
        }

        if ($routeRepository->willBeUsed($route) != 0) {
            //return
        }

        $entityManager->remove($route);
        $entityManager->flush();

    }

    /**
     * @param Route $route
     * @param User $user
     * @return bool
     */
    public function canDelete(Route $route, User $user)
    {
        if ($route->getUser()->getId() == $user->getId()) {
            return true;
        }
    }

}
