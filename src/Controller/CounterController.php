<?php

namespace App\Controller;

use App\Repository\CounterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CounterController extends AbstractController
{
    /**
     * @param CounterRepository $counterRepository
     * @return Response
     */
    public function index(CounterRepository $counterRepository): Response
    {
        return $this->render('counter/index.html.twig', [
            'counts' => $counterRepository->findAll(),
        ]);
    }
}