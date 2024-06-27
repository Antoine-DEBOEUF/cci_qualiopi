<?php

namespace App\Controller\Formateur;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ModuleRepository;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/formateur', 'app.formateur')]
class FormateurController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepo,
        private readonly EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher,
        private readonly ModuleRepository $moduleRepo
    ) {
    }
    #[Route('/{id}', name: '.profile', methods: ['GET'])]
    public function index(User $user, UserRepository $userRepo, ModuleRepository $moduleRepo, DocumentRepository $docuRepo): Response
    {

        $user = $this->getUser();


        return $this->render('Formateur/index.html.twig', [
            'user' => $userRepo->findOneById($user),
            'modules' => $moduleRepo->FindAll(),
            'documents' => $docuRepo->findAll(),

        ]);
    }

    #[Route('/{id}/edit', '.profile.edit', methods: ['GET', 'POST'])]
    public function edit(?User $user, Request $request): Response|RedirectResponse
    {


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->hasher->hashPassword($user, $form->get('password')->getData())
            );
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('app.formateur.profile', ['id' => $user->getId()]);
        }





        return $this->render('Formateur/edit.html.twig', [
            'form' => $form,

            'user' => $user,

        ]);
    }
}
