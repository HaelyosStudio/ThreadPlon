<?php

namespace App\Controller;

use App\Entity\Thread;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ThreadController extends AbstractController
{
    #[Route('/threads', name: 'app_thread_list')]
    public function threadList(EntityManagerInterface $entityManager): Response
    {
        $threadRepository = $entityManager->getRepository(Thread::class);

        $threads = $threadRepository->findAll();

        return $this->render('thread/threadList.html.twig', [
            'controller_name' => 'ThreadController',
            'threads' => $threads
        ]);
    }

    #[Route('/thread/{id}', name: 'app_thread')]
    public function threadDetails($id, EntityManagerInterface $entityManager): Response
    {

        $threadRepository = $entityManager->getRepository(Thread::class);

        $threads = $threadRepository->find($id);

        return $this->render('thread/threadDetails.html.twig', [
            'controller_name' => 'ThreadController',
            'threads' => $threads
        ]);
    }
}


