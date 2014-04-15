<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Route;
use Nfq\WeDriveBundle\Exception\RouteException;
use Nfq\WeDriveBundle\Form\RouteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Null;

/**
 * Manage route
 * Shows routes list
 *
 * Class RouteController
 * @package Nfq\WeDriveBundle\Controller
 */
class RouteController extends Controller
{
    /**
     * Returns Routes list
     *
     * @return Response
     */
    public function listAction()
    {
        $user1 = $this->getUser();

        $userRepository = $this->getDoctrine()->getRepository('NfqUserBundle:User');
        /** @var User $user */
        $user = $userRepository->findOneBy(array('username' => $user1->getUsername()));

        $routes = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findBy(
            array('user' => $user->getId())
        );
        if (!$routes) {
            //Throw exception
        }
        return $this->render('NfqWeDriveBundle:Route:list.html.twig', array('routes' => $routes));
    }

    /**
     * Adds new Route for logged in user
     *
     * @param \Symfony\Component\BrowserKit\Request|\Symfony\Component\HttpFoundation\Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(new RouteType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $route = $form->getData();

            $route->setUser($user);

            $em->persist($route);
            $em->flush();

            return new RedirectResponse($this->generateUrl('nfq_wedrive_route_list'));
        }

        return $this->render(
            'NfqWeDriveBundle:Route:add.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Deletes Route by id
     *
     * @param $routeId
     * @return RedirectResponse
     */
    public function deleteAction($routeId)
    {
        $user = $this->getUser();
        $routeRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route');
        $userRepository = $this->getDoctrine()->getRepository('NfqUserBundle:User');
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Route $route */
        $route = $routeRepository->findOneBy(array('id' => $routeId));

        /** @var User $user */
        $user = $userRepository->findOneBy(array('username' => $user->getUsername()));

        try {
            $this->checkIfRouteIsDeleteable($route, $user);
            $entityManager->remove($route);
            $entityManager->flush();
        } catch (RouteException $e) {
            die($e->getMessage());
        }

        return new RedirectResponse($this->generateUrl('nfq_wedrive_route_list'));
    }

    /**
     *
     * @param Route $route
     * @param User $user
     * @throws \Nfq\WeDriveBundle\Exception\RouteException
     * @throws \Nfq\WeDriveBundle\Exception\UserException
     * @return bool
     */
    public function checkIfRouteIsDeleteable(Route $route, User $user)
    {
        if ($route->getUser()->getId() !== $user->getId()) {
            throw new RouteException("Route doesn't belong to user");
        }

        $routeRepository = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route');

        if ($routeRepository->willBeUsed($route) != 0) {
            throw new RouteException("Route is already being used in a trip");
        }
    }

}
