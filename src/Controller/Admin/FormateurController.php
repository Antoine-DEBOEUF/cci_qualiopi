<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\InfosUser;
use App\Repository\UserRepository;
use App\Repository\InfosUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('admin/formateur', 'admin.formateur')]
class FormateurController extends AbstractController
{
    public function __construct(

        private readonly UserRepository $userRepo,
        private readonly EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    #[Route('/index', '.index', methods: ['GET'])]
    public function index(): Response
    {

        $users = $this->userRepo->findAll();

        return $this->render('Admin/Formateurs/index.html.twig', [

            'users' => $users
        ]);
    }




    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $em): Response|RedirectResponse
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->hasher->hashPassword($user, $form->get('password')->getData())
            );

            $em->persist($user);
            $em->flush();



            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin\Formateurs\create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?User $user, Request $request): Response|RedirectResponse
    {
        if (!$user) {
            return $this->redirectToRoute('admin.index');
        }

        $form = $this->createForm(UserType::class, $user, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin/Formateurs/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?User $user, Request $request): RedirectResponse
    {
        if (!$user) {


            return $this->redirectToRoute('admin.index');
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('token'))) {
            $this->em->remove($user);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.index');
    }
}
