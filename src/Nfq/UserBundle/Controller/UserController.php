<?php

namespace Nfq\UserBundle\Controller;

use Nfq\UserBundle\Form\Type\InvitationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController
 * @package Nfq\UserBundle\Controller
 */
class UserController extends Controller
{
    /**
     * Generates the invitation
     * TODO the entire generation part
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inviteAction()
    {

        $form = $this->createForm(new InvitationType());

        return $this->render('NfqUserBundle:Register:invite.html.twig', array('form' => $form->createView()));
    }

    public function registerAction()
    {
    }
}
