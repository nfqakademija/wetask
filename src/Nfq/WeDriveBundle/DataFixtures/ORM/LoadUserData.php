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

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $users= array(
            array('admin', 'test', 'admin@wedrive.dev','administrator','administrator-1'),
            array('observer', 'test', 'observer@wedrive.dev','observer','observer-1'),
            array('Petras', 'test', 'petras@wedrive.dev','user','user-1'),
            array('Jonas', 'test', 'jonas@wedrive.dev','user','user-2'),
            array('Viktorija', 'test', 'viktorija@wedrive.dev','user','user-3'),
            array('Pranas', 'test', 'pranas@wedrive.dev','user','user-4'),
            array('Kestas', 'test', 'kestas@wedrive.dev','user','user-5'),
            array('Daiva', 'test', 'daiva@wedrive.dev','user','user-6'),
            array('Veronika', 'test', 'veronika@wedrive.dev','user','user-7'),
            array('Monika', 'test', 'monika@wedrive.dev','user','user-8'),
            array('Ernestas', 'test', 'ernestas@wedrive.dev','user','user-9'),
            array('Domas', 'test', 'domas@wedrive.dev','user','user-10'),
            array('Tomas', 'test', 'tomas@wedrive.dev','user','user-11'),
            array('Markas', 'test', 'markas@wedrive.dev','user','user-12'),
        );

        foreach($users as $userData){
            $userUser = new User();
            $userUser->setUsername($userData[0]);
            $userUser->setPassword($userData[1]);
            $userUser->setEmail($userData[2]);
            $userUser->addRole($userData[3]);

            $manager->persist($userUser);

            $this->addReference($userData[4],$userUser);
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
