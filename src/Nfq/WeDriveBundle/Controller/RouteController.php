<?php

namespace Nfq\WeDriveBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Route;
use Nfq\WeDriveBundle\Entity\RoutePoint;
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
     * Lists saved routes for user
     *
     * @internal param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     */
    public function listAction()
    {
        $user1 = $this->getUser();
        /** @var  $userRepository */
        $userRepository = $this->getDoctrine()->getRepository('NfqUserBundle:User');
        /** @var  $user */
        $user = $userRepository->findOneBy(array('username' => $user1->getUsername()));
        /** @var  $routes */
        $routes = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findBy(
            array('user' => $user->getId())
        );

        if (!$routes) {
            //Throw exception for no routes

        }
        /** @var  $return */
        $return = array();
        foreach ($routes as $route) {
            $routePoints = $route->getRoutePoints();

            $routeRow = array(
                'route' => $route,
                'routePoints' => $routePoints
            );

            $return[] = $routeRow;
        }

        return $this->render('NfqWeDriveBundle:Route:list.html.twig', array('routes' => $return));
    }

    /**
     * Response for calling a new route with ajax
     *
     * @internal param $request
     * @return Response
     */
    public function newRouteAjaxAction()
    {
        return new Response($this->generateUrl('nfq_wedrive_route_list'));
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

        $routeForm = $this->createForm(new RouteType());

        $routeForm->handleRequest($request);

        if ($routeForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $route = $routeForm->getData();

            $route->setUser($user);

            $pointsJson = $routeForm->get('routePoints')->getData();
            $routePoints = json_decode($pointsJson, true);

            foreach ($routePoints as $key => $routePointData) {
                $routePoint = new RoutePoint();
                $routePoint->setLatitude($routePointData['k'])
                    ->setLongitude($routePointData['A'])
                    ->setRoute($route)
                    ->setPOrder($key);
                $em->persist($routePoint);
            }

            $em->persist($route);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->newRouteAjaxAction();
            }

            return new RedirectResponse($this->generateUrl('nfq_wedrive_route_list'));
        }

        return $this->render(
            'NfqWeDriveBundle:Route:newRoute.html.twig',
            array(
                'routeForm' => $routeForm->createView(),
            )
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
     * Deletes route by id
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
     * Checks if user owns the route and if it's not used in future trips
     *
     * @param Route $route
     * @param User $user
     * @throws RouteException
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
