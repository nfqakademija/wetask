<?php
/**
 * Created by PhpStorm.
 * User: ITP
 * Date: 14.4.1
 * Time: 10.17
 */
namespace Nfq\WeDriveBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nfq\UserBundle\Entity\Invitation;
use Nfq\UserBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadInvitationData
 * Loads fixtures for Invitations in defined order
 *
 * @package Nfq\WeDriveBundle\DataFixtures\ORM
 */
class LoadInvitationData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Loads fixtures for Passenger in defined order
     *
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $invitations = array(
            array('test0@wedrive.dev', 'wwwww0', true),
            array('test1@wedrive.dev', 'wwwww1', true),
            array('test2@wedrive.dev', 'wwwww2', true),
            array('test3@wedrive.dev', 'wwwww3', true),
        );
      //  $invitationManager = $this->container->get('fos_user.invitation_manager');

        foreach ($invitations as $invitationData) {
            /** @var Invitation $invitation */
            $invitation = new Invitation();
            $invitation->setEmail($invitationData[0]);
            $invitation->setCode($invitationData[1]);
            $invitation->setSent($invitationData[2]);

         //   $manager->persist($invitation);
        }

       // $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}
