<?php

namespace App\Controller;

use App\Entity\Response as ResponseEntity;
use App\Entity\Thread;
use App\Entity\ThreadVote;
use App\Form\ResponseCreationType;
use App\Form\ThreadCreationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ThreadController extends AbstractController
{
    #[Route('/', name: 'app_thread_list')]
    public function threadList(EntityManagerInterface $entityManager): Response
    {
        $threadRepository = $entityManager->getRepository(Thread::class);

        $threads = $threadRepository->findAll();

        return $this->render('thread/threadList.html.twig', [
            'threads' => $threads
        ]);
    }

    #[Route('/thread/creation', name: 'app_thread_creation')]
    public function createThread(Request $request, EntityManagerInterface $entityManager): Response
    {
        $thread = new Thread();
        $thread->setStatus('open');
        $thread->setCreated(new \DateTimeImmutable());
        $thread->setEdited(new \DateTimeImmutable());
        $thread->setUser($this->getUser());
    
        $form = $this->createForm(ThreadCreationType::class, $thread);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($thread);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_thread_list', ['id' => $thread->getId()]);
        }
    
        return $this->render('thread/threadCreation.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/thread/{id}', name: 'app_thread')]
    public function threadDetails($id, EntityManagerInterface $entityManager): Response
    {

        $threadRepository = $entityManager->getRepository(Thread::class);

        $threads = $threadRepository->find($id);

        return $this->render('thread/threadDetails.html.twig', [
            'threads' => $threads
        ]);
    }

    #[Route('/thread/{id}/vote', name: 'app_thread_vote')]
    public function vote(Thread $thread, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $direction = $request->query->get('direction');
    
        if (!$user || !in_array($direction, ['up', 'down'])) {
            return new Response('Invalid request', 400);
        }
    
        $threadVote = new ThreadVote();
        $threadVote->setThread($thread);
        $threadVote->setUser($user);
        $threadVote->setVote($direction === 'up');
    
        $entityManager->persist($threadVote);
        $entityManager->flush();
    
        $totalVotes = $thread->getTotalVotes();
    
        return new Response(sprintf('Vote recorded successfully. Total votes: %d', $totalVotes), 200);
    }
    
    #[Route('/thread/{id}/edit', name: 'app_thread_edit')]
    public function editThread(Request $request, Thread $thread, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThreadCreationType::class, $thread);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_thread_show', ['id' => $thread->getId()]);
        }
    
        return $this->render('thread/threadEdit.html.twig', [
            'form' => $form->createView(),
            'thread' => $thread,
        ]);
    }

    #[Route('/thread/{id}/response/create', name: 'app_response_create')]
    public function createResponse(Request $request, Thread $thread, EntityManagerInterface $entityManager): Response
    {
        $response = new ResponseEntity();
        $response->setThread($thread);
        $response->setUser($this->getUser());
        $response->setCreated(new \DateTimeImmutable());
        $response->setEdited(new \DateTimeImmutable());

        $form = $this->createForm(ResponseCreationType::class, $response);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($response);
            $entityManager->flush();

            return $this->redirectToRoute('app_thread', ['id' => $thread->getId()]);
        }

        return $this->render('thread/threadResponseCreation.html.twig', [
            'form' => $form->createView(),
            'thread' => $thread,
        ]);
    }
    
}


