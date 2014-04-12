<?php

namespace Nfq\WeDriveBundle\Controller;

use Nfq\UserBundle\Entity\User;
use Nfq\WeDriveBundle\Entity\Route;
use Nfq\WeDriveBundle\Exception\RouteException;
use Nfq\WeDriveBundle\Form\RouteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Null;

/**
 * Class RouteController
 * @package Nfq\WeDriveBundle\Controller
 */
class RouteController extends Controller
{
    /**
     * @return Response
     */
    public function listAction()
    {
        $user1 = $this->container->get('security.context')->getToken()->getUser();

        $userRepository = $this->getDoctrine()->getRepository('NfqUserBundle:User');
        /** @var User $user */
        $user = $userRepository->findOneBy(array('username' => $user1->getUsername()));

        $routes = $this->getDoctrine()->getRepository('NfqWeDriveBundle:Route')->findBy(
            array('user' => $user->getId())
        );
        if (!$routes) {
            //Throw exception
        }
        return $this->render('NfqWeDriveBundle:Route:list.html.twig', array('routes' => $routes, 'user' => $user1));
    }

    /**
     * @return Response
     */
    public function addAction()
    {
        $user1 = $this->container->get('security.context')->getToken()->getUser();

        $route = new Route();
        $route->setName("Name your route");
        $route->setDestination("Name your  destination");

        $form = $this->createFormBuilder($route)
            ->add('name','text')
            ->add('destination','text')
            ->getForm();

        return $this->render('NfqWeDriveBundle:Route:add.html.twig', array('form' => $form->createView(),'user' => $user1));
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
