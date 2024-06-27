<?php

namespace App\Controller\Formateur;

use App\Entity\User;
use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\UserRepository;
use App\Repository\ModuleRepository;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/formateur', 'app.formateur')]
class DocumentController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepo,
        private readonly EntityManagerInterface $em,
        private readonly DocumentRepository $docuRepo,
        private readonly ModuleRepository $moduleRepo
    ) {
    }

    #[Route('/{id}/document', name: '.document')]
    public function index(UserRepository $userRepo, User $user, ModuleRepository $moduleRepo, DocumentRepository $docuRepo): Response
    {
        return $this->render('document/index.html.twig', [
            'user' => $userRepo->findOneById($user->getId()),
            'documents' => $docuRepo->findAllByUser($user),
        ]);
    }

    #[Route('/document/upload', name: '.document.upload')]
    public function upload(Request $request, UserRepository $userRepo): Response|RedirectResponse
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

            return $this->redirectToRoute('app.formateur.profile', ['id' => $user->getId()]);
        };
        return $this->render('Formateur/Documents/upload.html.twig', [
            'form' => $form,
            'user' => $userRepo->findOneById($user->getId()),
        ]);
    }

    #[Route('/documents/{id}/edit', name: '.document.edit')]
    public function edit(Request $request, UserRepository $userRepo, ?Document $document): Response|RedirectResponse
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        /** @var User $user */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $document->setUser($user);
            $this->em->persist($document);
            $this->em->flush();

            return $this->redirectToRoute('app.formateur.profile', ['id' => $user->getId()]);
        };
        return $this->render('Formateur/Documents/edit.html.twig', [
            'form' => $form,
            'user' => $userRepo->findOneById($user->getId()),
        ]);
    }
}
