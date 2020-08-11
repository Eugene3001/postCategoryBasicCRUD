<?php

namespace App\Service;

use App\Entity\Post;
use App\Event\EntityCountCreationEvent;
use App\Event\EntityCountRemovingEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class PostManager
{
    private $em;
    private $eventDispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(Post $post): Post
    {
        $this->em->persist($post);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EntityCountCreationEvent(Post::class));

        return $post;
    }

    public function delete(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EntityCountRemovingEvent(Post::class));
    }
}