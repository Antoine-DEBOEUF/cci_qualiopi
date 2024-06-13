<?php

namespace App\Controller\Admin;

use App\Repository\DocumentRepository;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin', 'admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepo,
        private readonly SessionRepository $sessionRepo,
        private readonly DocumentRepository $docRepo,

    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        $users = $this->userRepo->findAll();
        $sessions = $this->sessionRepo->findAll();


        // dump($users);
        // dd($sessions);

        return $this->render('Admin/index.html.twig', [
            'users' => $users,
            'sessions' => $sessions,
            'documents' => $this->docRepo->findAll()
        ]);
    }
}
