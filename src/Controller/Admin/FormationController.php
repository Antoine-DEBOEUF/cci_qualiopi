<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/formations', name: 'admin.formations')]
class FormationController extends AbstractController
{
    public function __construct(
        private readonly FormationRepository $formaRepo,
        private readonly EntityManagerInterface $em,
    ) {
    }
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        $formations = $this->formaRepo->findAll();

        return $this->render('Admin/Formations/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response|RedirectResponse
    {
        $formation = new Formation;

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin\Formations\create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Formation $formation, Request $request): Response|RedirectResponse
    {
        if (!$formation) {
            return $this->redirectToRoute('admin.index');
        }

        $form = $this->createForm(FormationType::class, $formation, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($formation);
            $this->em->flush();

            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin/Formations/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Formation $formation, Request $request): RedirectResponse
    {
        if (!$formation) {

            return $this->redirectToRoute('admin.index');
        }

        if ($this->isCsrfTokenValid('delete' . $formation->getId(), $request->request->get('token'))) {
            $this->em->remove($formation);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.index');
    }
}
