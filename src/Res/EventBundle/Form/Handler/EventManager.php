<?php

namespace Res\EventBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Res\EventBundle\Entity\Event;

class EventManager
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Event $event)
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
        ldd($event);
    }
}
