<?php

namespace App\Event;

use App\Entity\Counter;
use App\Repository\CounterRepository;
use Doctrine\ORM\EntityManagerInterface;

class EntityCountListener
{
    private $counterRepository;
    private $em;

    public function __construct(CounterRepository $counterRepository, EntityManagerInterface $em)
    {
        $this->counterRepository = $counterRepository;
        $this->em = $em;
    }

    public function onEntityCreate(EntityCountCreationEvent $entityCountCreationEvent)
    {
        $counter = $this->counterRepository->findOneBy(['className' => $entityCountCreationEvent->getClassName()]);

        if ($counter != null) {
            $counter->setCount($counter->getCount() + 1);
        } else {
            $counter = new Counter();
            $counter->setClassName($entityCountCreationEvent->getClassName());
            $counter->setCount(1);
        }

        $this->em->persist($counter);
        $this->em->flush();
    }

    public function onEntityDelete(EntityCountRemovingEvent $entityCountRemovingEvent)
    {
        $counter = $this->counterRepository->findOneBy(['className' => $entityCountRemovingEvent->getClassName()]);

        if ($counter != null) {
            $counter->setCount($counter->getCount() > 0 ? $counter->getCount() - 1 : 0);
        } else {
            $counter = new Counter();
            $counter->setClassName($entityCountRemovingEvent->getClassName());
            $counter->setCount(1);
        }

        $this->em->persist($counter);
        $this->em->flush();
    }
}