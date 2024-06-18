<?php

namespace App\Controller\Admin;

use App\Repository\DocumentRepository;
use App\Repository\FormationRepository;
use App\Repository\ModuleRepository;
use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin', 'admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepo,
        private readonly ModuleRepository $moduleRepo,
        private readonly DocumentRepository $docRepo,
        private readonly FormationRepository $formaRepo

    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        $users = $this->userRepo->findAll();
        $modules = $this->moduleRepo->findAll();


        // dump($users);
        // dd($sessions);

        return $this->render('Admin/index.html.twig', [
            'users' => $users,
            'modules' => $modules,
            'documents' => $this->docRepo->findAll(),
            'formations' => $this->formaRepo->findAll()
        ]);
    }
}
