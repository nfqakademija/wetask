<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Route;
use Nfq\WeDriveBundle\Exception\RouteException;
use Nfq\WeDriveBundle\Exception\UserException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
     * @return RedirectResponse
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

        $this->canDelete($route,$user);

        $entityManager->remove($route);
        $entityManager->flush();

//        die();
        return new RedirectResponse($this->generateUrl('nfq_wedrive_route_list'));
    }

    /**
     * @param Route $route
     * @param User $user
     * @throws \Nfq\WeDriveBundle\Exception\RouteException
     * @throws \Nfq\WeDriveBundle\Exception\UserException
     * @return bool
     */
    public function canDelete(Route $route, User $user)
    {
        if ($route->getUser()->getId() !== $user->getId()) {
            throw new UserException;
        } else {
            $routeRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route');
            if ($routeRepository->willBeUsed($route) != 0) {
                throw new RouteException;
            }
        }
    }

}
