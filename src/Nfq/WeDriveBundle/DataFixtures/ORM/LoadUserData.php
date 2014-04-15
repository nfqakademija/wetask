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
use Nfq\UserBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * Loads fixtures for User in defined order
 *
 * @package Nfq\WeDriveBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $users = array(
            array('admin', 'test', 'admin@wedrive.dev', 'ROLE_ADMIN', 'administrator-1',true),
            array('observer', 'test', 'observer@wedrive.dev', 'ROLE_OBSERVER', 'observer-1',true),
            array('Petras', 'test', 'petras@wedrive.dev', 'ROLE_USER', 'user-1',true),
            array('Jonas', 'test', 'jonas@wedrive.dev', 'ROLE_USER', 'user-2',true),
            array('Viktorija', 'test', 'viktorija@wedrive.dev', 'ROLE_USER', 'user-3',true),
            array('Pranas', 'test', 'pranas@wedrive.dev', 'ROLE_USER', 'user-4',true),
            array('Kestas', 'test', 'kestas@wedrive.dev', 'ROLE_USER', 'user-5',true),
            array('Daiva', 'test', 'daiva@wedrive.dev', 'ROLE_USER', 'user-6',true),
            array('Veronika', 'test', 'veronika@wedrive.dev', 'ROLE_USER', 'user-7',true),
            array('Monika', 'test', 'monika@wedrive.dev', 'ROLE_USER', 'user-8',true),
            array('Ernestas', 'test', 'ernestas@wedrive.dev', 'ROLE_USER', 'user-9',true),
            array('Domas', 'test', 'domas@wedrive.dev', 'ROLE_USER', 'user-10',true),
            array('Tomas', 'test', 'tomas@wedrive.dev', 'ROLE_USER', 'user-11',true),
            array('Markas', 'test', 'markas@wedrive.dev', 'ROLE_USER', 'user-12',true),
        );

        $userManager = $this->container->get('fos_user.user_manager');

        foreach ($users as $userData) {
            $userUser = $userManager->createUser();
            $userUser->setUsername($userData[0]);
            $userUser->setPlainPassword($userData[1]);
            $userUser->setEmail($userData[2]);
            $userUser->setRoles(array($userData[3]));
            $userUser->setEnabled($userData[5]);

            $manager->persist($userUser);

            $this->addReference($userData[4], $userUser);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
