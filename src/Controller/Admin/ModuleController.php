<?php

namespace App\Controller\Admin;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\DocumentRepository;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/modules', 'admin.module')]
class ModuleController extends AbstractController

{
    public function __construct(
        private readonly ModuleRepository $moduleRepo,
        private readonly EntityManagerInterface $em,

    ) {
    }

    #[Route('/index', '.index', methods: ['GET'])]
    public function index(ModuleRepository $moduleRepo, DocumentRepository $documentRepository): Response
    {
        //$sessions = $this->sessionRepo->findAll();

        return $this->render('Admin/Modules/index.html.twig', [
            'modules' => $moduleRepo->findAll(),
            'documents' => $documentRepository->findAll()
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response|RedirectResponse
    {
        $module = new Module;

        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($module);
            $em->flush();



            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin\Modules\create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Module $module, Request $request): Response|RedirectResponse
    {
        if (!$module) {
            return $this->redirectToRoute('admin.index');
        }

        $form = $this->createForm(ModuleType::class, $module, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($module);
            $this->em->flush();

            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin/Modules/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Module $module, Request $request): RedirectResponse
    {
        if (!$module) {


            return $this->redirectToRoute('admin.index');
        }

        if ($this->isCsrfTokenValid('delete' . $module->getId(), $request->request->get('token'))) {
            $this->em->remove($module);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.index');
    }
}
