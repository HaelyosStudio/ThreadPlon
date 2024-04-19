<?php

namespace App\Controller;

use App\Entity\Response as ResponseEntity;
use App\Entity\ResponseVote;
use App\Entity\Thread;
use App\Entity\ThreadVote;
use App\Form\ResponseCreationType;
use App\Form\ThreadCreationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
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
        $responses = $threads->getResponses();

        return $this->render('thread/threadDetails.html.twig', [
            'threads' => $threads,
            'responses' => $responses
        ]);
    }

    #[Route('/thread/{id}/voteUp', name: 'app_thread_vote_up')]
    public function voteUp(Thread $thread, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return new Response('Invalid request', 400);
        }

        $existingVote = $entityManager->getRepository(ThreadVote::class)->findOneBy([
            'thread' => $thread,
            'user' => $user
        ]);

        if ($existingVote) {
            if (!$existingVote->isVote()) {
                $existingVote->setVote(true);
                $entityManager->flush();
            } else {
                $entityManager->remove($existingVote);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_thread', ['id' => $thread->getId()]);
        }

        $threadVote = new ThreadVote();
        $threadVote->setThread($thread);
        $threadVote->setUser($user);
        $threadVote->setVote(true);

        $entityManager->persist($threadVote);
        $entityManager->flush();

        return $this->redirectToRoute('app_thread', ['id' => $thread->getId()]);
    }

    #[Route('/thread/{id}/voteDown', name: 'app_thread_vote_down')]
    public function voteDown(Thread $thread, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return new Response('Invalid request', 400);
        }

        $existingVote = $entityManager->getRepository(ThreadVote::class)->findOneBy([
            'thread' => $thread,
            'user' => $user
        ]);

        if ($existingVote) {
            if ($existingVote->isVote()) {
                $existingVote->setVote(false);
                $entityManager->flush();
            } else {
                $entityManager->remove($existingVote);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_thread', ['id' => $thread->getId()]);
        }

        $threadVote = new ThreadVote();
        $threadVote->setThread($thread);
        $threadVote->setUser($user);
        $threadVote->setVote(false);

        $entityManager->persist($threadVote);
        $entityManager->flush();

        return $this->redirectToRoute('app_thread', ['id' => $thread->getId()]);
    }

    #[Route('/response/{id}/voteUp', name: 'app_response_vote_up')]
    public function voteResponseUp(ResponseEntity $response, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
    
        if (!$user) {
            return new Response('Invalid request', 400);
        }
    
        $existingVote = $entityManager->getRepository(ResponseVote::class)->findOneBy([
            'response' => $response,
            'user' => $user
        ]);
    
        if ($existingVote) {
            if (!$existingVote->isVote()) {
                $existingVote->setVote(true);
                $entityManager->flush();
            } else {
                $entityManager->remove($existingVote);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('app_thread', ['id' => $response->getThread()->getId()]);
        }
    
        $responseVote = new ResponseVote();
        $responseVote->setResponse($response);
        $responseVote->setUser($user);
        $responseVote->setVote(true);
    
        $entityManager->persist($responseVote);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_thread', ['id' => $response->getThread()->getId()]);
    }
    

    #[Route('/response/{id}/voteDown', name: 'app_response_vote_down')]
    public function voteResponseDown(ResponseEntity $response, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
    
        if (!$user) {
            return new Response('Invalid request', 400);
        }
    
        $existingVote = $entityManager->getRepository(ResponseVote::class)->findOneBy([
            'response' => $response,
            'user' => $user
        ]);
    
        if ($existingVote) {
            if ($existingVote->isVote()) {
                $existingVote->setVote(false);
                $entityManager->flush();
            } else {
                $entityManager->remove($existingVote);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('app_thread', ['id' => $response->getThread()->getId()]);
        }
    
        $responseVote = new ResponseVote();
        $responseVote->setResponse($response);
        $responseVote->setUser($user);
        $responseVote->setVote(false);
    
        $entityManager->persist($responseVote);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_thread', ['id' => $response->getThread()->getId()]);
    }

    #[Route('/thread/{id}/edit', name: 'app_thread_edit')]
    public function editThread(Request $request, Thread $thread, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThreadCreationType::class, $thread);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_thread_list', ['id' => $thread->getId()]);
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

    #[Route('/responses/{id}', name: 'app_response_delete', methods: ['DELETE', 'POST'])]
    public function delete(ResponseEntity $response, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if ($user === null || (!in_array('ROLE_ADMIN', $user->getRoles()) && $response->getUser() !== $user && $response->getThread()->getUser() !== $user)) {
            throw new AccessDeniedException('You do not have permission to delete this response.');
        }

        $entityManager->remove($response);
        $entityManager->flush();

        return $this->redirectToRoute('app_thread', ['id' => $response->getThread()->getId()]);
    }
}
