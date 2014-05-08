<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Route;
use Nfq\WeDriveBundle\Exception\RouteException;
use Nfq\WeDriveBundle\Form\Type\RouteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     */
    public function listAction(Request $request)
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

        $return = array();
        foreach ($routes as $route) {
            $routePoints = $route->getRoutePoints();

            $routeobj = array(
                'route' => $route,
                'routePoints' => $routePoints
            );

            $return[] = $routeobj;
        }

        return $this->render('NfqWeDriveBundle:Route:list.html.twig', array('routes' => $return));
    }

    /**
     * Adds new Route for logged in user
     *
     * @param \Symfony\Component\BrowserKit\Request|\Symfony\Component\HttpFoundation\Request $request
     * @return Response
     */
    public function newRouteAction(Request $request)
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
            'NfqWeDriveBundle:Route:newRoute.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Displays the route management page
     *
     * @param Request $request
     * @param $routeId
     * @return RedirectResponse|Response
     */
    public function manageAction($routeId, Request $request)
    {
        $user = $this->getUser();

        $route = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findOneBy(
            array('id' => $routeId)
        );

        $form = $this->createForm(new RouteType(), $route);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($route);
            $em->flush();

            return $this->redirect($this->generateUrl('nfq_wedrive_route_list'));
        }

        return $this->render(
            'NfqWeDriveBundle:Route:manage.html.twig',
            array('route' => $route, 'form' => $form->createView())
        );
    }

    /**
     * Deletes Route by id
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param $routeId
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $routeId)
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
//            $route->unsetAllTrips();
            $entityManager->remove($route);
            $entityManager->flush();
        } catch (RouteException $e) {
            $request->getSession()->getFlashBag()->add('error', $e->getMessage());
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
