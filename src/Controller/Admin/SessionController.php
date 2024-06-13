<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\DocumentRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/sessions', 'admin.session')]
class SessionController extends AbstractController

{
    public function __construct(
        private readonly SessionRepository $sessionRepo,
        private readonly EntityManagerInterface $em,

    ) {
    }

    #[Route('/index', '.index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepo, DocumentRepository $documentRepository): Response
    {
        //$sessions = $this->sessionRepo->findAll();

        return $this->render('Admin/Sessions/index.html.twig', [
            'sessions' => $sessionRepo->findAll(),
            'documents' => $documentRepository->findAll()
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response|RedirectResponse
    {
        $session = new Session();

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($session);
            $em->flush();



            return $this->redirectToRoute('.index');
        }

        return $this->render('Admin\Sessions\create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Session $session, Request $request): Response|RedirectResponse
    {
        if (!$session) {
            return $this->redirectToRoute('admin.index');
        }

        $form = $this->createForm(SessionType::class, $session, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($session);
            $this->em->flush();

            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin/Sessions/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Session $session, Request $request): RedirectResponse
    {
        if (!$session) {


            return $this->redirectToRoute('admin.index');
        }

        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('token'))) {
            $this->em->remove($session);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.index');
    }
}
