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
            array('admin', 'Test123123', 'admin@wedrive.dev', 'ROLE_ADMIN', 'administrator-1',true),
            array('observer', 'Test123123', 'observer@wedrive.dev', 'ROLE_OBSERVER', 'observer-1',true),
            array('Petras', 'Test123123', 'petras@wedrive.dev', 'ROLE_USER', 'user-1',true),
            array('Jonas', 'Test123123', 'jonas@wedrive.dev', 'ROLE_USER', 'user-2',true),
            array('Viktorija', 'Test123123', 'viktorija@wedrive.dev', 'ROLE_USER', 'user-3',true),
            array('Pranas', 'Test123123', 'pranas@wedrive.dev', 'ROLE_USER', 'user-4',true),
            array('Kestas', 'Test123123', 'kestas@wedrive.dev', 'ROLE_USER', 'user-5',true),
            array('Daiva', 'Test123123', 'daiva@wedrive.dev', 'ROLE_USER', 'user-6',true),
            array('Veronika', 'Test123123', 'veronika@wedrive.dev', 'ROLE_USER', 'user-7',true),
            array('Monika', 'Test123123', 'monika@wedrive.dev', 'ROLE_USER', 'user-8',true),
            array('Ernestas', 'Test123123', 'ernestas@wedrive.dev', 'ROLE_USER', 'user-9',true),
            array('Domas', 'Test123123', 'domas@wedrive.dev', 'ROLE_USER', 'user-10',true),
            array('Tomas', 'Test123123', 'tomas@wedrive.dev', 'ROLE_USER', 'user-11',true),
            array('Markas', 'Test123123', 'markas@wedrive.dev', 'ROLE_USER', 'user-12',true),
            array('Olga', 'Test123123', 'olga@wedrive.dev', 'ROLE_USER', 'user-13',true),
            array('Asta', 'Test123123', 'asta@wedrive.dev', 'ROLE_USER', 'user-14',true),
            array('Gintas', 'Test123123', 'gintas@wedrive.dev', 'ROLE_USER', 'user-15',true),
            array('Aiste', 'Test123123', 'aiste@wedrive.dev', 'ROLE_USER', 'user-16',true),
            array('Justas', 'Test123123', 'justas@wedrive.dev', 'ROLE_USER', 'user-17',true),
            array('Titas', 'Test123123', 'titas@wedrive.dev', 'ROLE_USER', 'user-18',true),
            array('Mantas', 'Test123123', 'mantas@wedrive.dev', 'ROLE_USER', 'user-19',true),
            array('Mikolas', 'Test123123', 'mikolas@wedrive.dev', 'ROLE_USER', 'user-20',true),
            array('Mindaugas', 'Test123123', 'mindaugas@wedrive.dev', 'ROLE_USER', 'user-21', true),
            array('Vilius', 'Test123123', 'vilius@wedrive.dev', 'ROLE_USER', 'user-22', true),
            array('Greta', 'Test123123', 'greta@wedrive.dev', 'ROLE_USER', 'user-23', true),
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
