<?php

namespace App\Controller\Admin;

use App\Entity\InfosUser;
use App\Form\InfosUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InfosUserController extends AbstractController
{
    #[Route('admin/formateur/create', name: 'app_infos_user')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = new InfosUser();

        $form = $this->createForm(InfosUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($user);
            $em->flush();



            return $this->redirectToRoute('admin.index');
        }

        return $this->render('Admin\Formateurs\create.html.twig', [
            'form' => $form,
        ]);
    }
}
