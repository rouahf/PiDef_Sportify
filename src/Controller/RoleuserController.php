<?php

namespace App\Controller;

use App\Entity\Roleuser;
use App\Form\RoleuserType;
use App\Repository\RoleuserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/roleuser')]
class RoleuserController extends AbstractController
{
    #[Route('/', name: 'app_roleuser_index', methods: ['GET'])]
    public function index(RoleuserRepository $roleuserRepository): Response
    {
        return $this->render('roleuser/index.html.twig', [
            'roleusers' => $roleuserRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_roleuser_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RoleuserRepository $roleuserRepository): Response
    {
        $roleuser = new Roleuser();
        $form = $this->createForm(RoleuserType::class, $roleuser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roleuserRepository->save($roleuser, true);

            return $this->redirectToRoute('app_roleuser_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('roleuser/new.html.twig', [
            'roleuser' => $roleuser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_roleuser_show', methods: ['GET'])]
    public function show(Roleuser $roleuser): Response
    {
        return $this->render('roleuser/show.html.twig', [
            'roleuser' => $roleuser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_roleuser_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Roleuser $roleuser, RoleuserRepository $roleuserRepository): Response
    {
        $form = $this->createForm(RoleuserType::class, $roleuser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roleuserRepository->save($roleuser, true);

            return $this->redirectToRoute('app_roleuser_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('roleuser/edit.html.twig', [
            'roleuser' => $roleuser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_roleuser_delete', methods: ['POST'])]
    public function delete(Request $request, Roleuser $roleuser, RoleuserRepository $roleuserRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$roleuser->getId(), $request->request->get('_token'))) {
            $roleuserRepository->remove($roleuser, true);
        }

        return $this->redirectToRoute('app_roleuser_index', [], Response::HTTP_SEE_OTHER);
    }
}
