<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Event;

class LoadEventData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $events = array(
            array('name' => 'Evento 1', 'desciption' => 'Descripcion primera', 'owner' => $this->getReference('user1')),
            array('name' => 'Evento 2', 'desciption' => 'Descripcion segunda', 'owner' => $this->getReference('user1')),
            array('name' => 'Evento 3', 'desciption' => 'Descripcion otro usuario', 'owner' => $this->getReference('user2')),
        );
        foreach ($events as $event) {
            $entity = new Event();
            $entity->setName($event['name']);
            $entity->setDescription($event['desciption']);
            $entity->setOwner($event['owner']);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}