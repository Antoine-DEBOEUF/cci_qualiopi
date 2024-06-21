<?php

namespace App\Controller\Admin;

use App\Entity\Site;
use App\Form\SiteType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('admin/site', 'admin.site')]
class SiteController extends AbstractController
{
    public function __construct(

        private readonly SiteRepository $siteRepo,
        private readonly EntityManagerInterface $em,

    ) {
    }

    #[Route('/index', '.index', methods: ['GET'])]
    public function index(): Response
    {

        $sites = $this->siteRepo->findAll();

        return $this->render('Admin/Sites/index.html.twig', [

            'sites' => $sites
        ]);
    }




    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response|RedirectResponse
    {
        $site = new Site();

        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($site);
            $em->flush();



            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin\Sites\create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Site $site, Request $request): Response|RedirectResponse
    {

        if (!$site) {
            return $this->redirectToRoute('admin.index');
        }

        $form = $this->createForm(SiteType::class, $site, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($site);
            $this->em->flush();

            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin/Sites/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Site $site, Request $request): RedirectResponse
    {
        if (!$site) {


            return $this->redirectToRoute('admin.index');
        }

        if ($this->isCsrfTokenValid('delete' . $site->getId(), $request->request->get('token'))) {
            $this->em->remove($site);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.index');
    }
}
