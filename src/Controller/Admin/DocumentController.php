<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\UserRepository;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/documents', 'admin.documents')]
class DocumentController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepo,
        private readonly EntityManagerInterface $em,
        private readonly DocumentRepository $docuRepo,

    ) {
    }

    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('Admin/Documents/index.html.twig', [

            'documents' => $this->docuRepo->findAll(),
        ]);
    }

    #[Route('/upload', name: '.upload')]
    public function upload(Request $request): Response|RedirectResponse
    {

        $document = new Document();

        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        /** @var User $user */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {



            $document->setUser($user);
            $this->em->persist($document);
            $this->em->flush();

            return $this->redirectToRoute('admin.index', ['id' => $user->getId()]);
        };
        return $this->render('Admin/Documents/upload.html.twig', [
            'form' => $form,
            'user' => $user->getId()
        ]);
    }

    #[Route('/{id}/edit', name: '.edit')]
    public function edit(Request $request, ?Document $document): Response|RedirectResponse
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        /** @var User $user */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $document->setUser($user);
            $this->em->persist($document);
            $this->em->flush();

            return $this->redirectToRoute('admin.index', ['id' => $user->getId()]);
        };

        return $this->render('Admin/Documents/edit.html.twig', [
            'form' => $form,
            'user' => $user->getId()

        ]);
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?Document $document, Request $request): RedirectResponse
    {

        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->request->get('token'))) {
            $this->em->remove($document);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.index');
    }
}
