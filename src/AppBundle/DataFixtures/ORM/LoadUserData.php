<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<=20; $i++) 
        {
            $user = new User();

            $user->setUsername('user'.$i);
            $user->setEmail('user'.$i.'@example.com');            
            $user->setPlainPassword('1234');
            $user->setRoles(array('ROLE_USER'));
            $user->setEnabled(true);

            $manager->persist($user);
            
            $this->addReference('user'.$i, $user);
        }
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 1;
    }
    
}