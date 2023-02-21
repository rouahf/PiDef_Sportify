<?php

namespace App\Controller;

use App\Entity\Reclamationn;
use App\Form\ReclamationnType;
use App\Repository\ReclamationnRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reclamationn')]
class ReclamationnController extends AbstractController
{
    #[Route('/', name: 'app_reclamationn_index', methods: ['GET'])]
    public function index(ReclamationnRepository $reclamationnRepository): Response
    {
        return $this->render('reclamationn/index.html.twig', [
            'reclamationns' => $reclamationnRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reclamationn_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationnRepository $reclamationnRepository): Response
    {
        $reclamationn = new Reclamationn();
        $form = $this->createForm(ReclamationnType::class, $reclamationn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationnRepository->save($reclamationn, true);

            return $this->redirectToRoute('app_reclamationn_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamationn/new.html.twig', [
            'reclamationn' => $reclamationn,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamationn_show', methods: ['GET'])]
    public function show(Reclamationn $reclamationn): Response
    {
        return $this->render('reclamationn/show.html.twig', [
            'reclamationn' => $reclamationn,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamationn_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamationn $reclamationn, ReclamationnRepository $reclamationnRepository): Response
    {
        $form = $this->createForm(ReclamationnType::class, $reclamationn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationnRepository->save($reclamationn, true);

            return $this->redirectToRoute('app_reclamationn_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamationn/edit.html.twig', [
            'reclamationn' => $reclamationn,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamationn_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamationn $reclamationn, ReclamationnRepository $reclamationnRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamationn->getId(), $request->request->get('_token'))) {
            $reclamationnRepository->remove($reclamationn, true);
        }

        return $this->redirectToRoute('app_reclamationn_index', [], Response::HTTP_SEE_OTHER);
    }
}
