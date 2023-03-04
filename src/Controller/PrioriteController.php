<?php

namespace App\Controller;

use App\Entity\Priorite;
use App\Form\PrioriteType;
use App\Repository\PrioriteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/priorite')]
class PrioriteController extends AbstractController
{
    #[Route('/', name: 'app_priorite_index', methods: ['GET'])]
    public function index(PrioriteRepository $prioriteRepository): Response
    {
        return $this->render('priorite/index.html.twig', [
            'priorites' => $prioriteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_priorite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PrioriteRepository $prioriteRepository): Response
    {
        $priorite = new Priorite();
        $form = $this->createForm(PrioriteType::class, $priorite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prioriteRepository->save($priorite, true);

            return $this->redirectToRoute('app_priorite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('priorite/new.html.twig', [
            'priorite' => $priorite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_priorite_show', methods: ['GET'])]
    public function show(Priorite $priorite): Response
    {
        return $this->render('priorite/show.html.twig', [
            'priorite' => $priorite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_priorite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Priorite $priorite, PrioriteRepository $prioriteRepository): Response
    {
        $form = $this->createForm(PrioriteType::class, $priorite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prioriteRepository->save($priorite, true);

            return $this->redirectToRoute('app_priorite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('priorite/edit.html.twig', [
            'priorite' => $priorite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_priorite_delete', methods: ['POST'])]
    public function delete(Request $request, Priorite $priorite, PrioriteRepository $prioriteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$priorite->getId(), $request->request->get('_token'))) {
            $prioriteRepository->remove($priorite, true);
        }

        return $this->redirectToRoute('app_priorite_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
