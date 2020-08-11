<?php

namespace App\Service;

use App\Entity\Category;
use App\Event\EntityCountCreationEvent;
use App\Event\EntityCountRemovingEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CategoryManager
{
    private $em;
    private $eventDispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(Category $category): Category
    {
        $this->em->persist($category);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EntityCountCreationEvent(Category::class));

        return $category;
    }

    public function delete(Category $category)
    {
        $this->em->remove($category);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EntityCountRemovingEvent(Category::class));
    }
}