<?php

namespace App\Controller;

use App\Entity\CategorieA;
use App\Form\CategorieAType;
use App\Repository\CategorieARepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie/a')]
class CategorieAController extends AbstractController
{
    #[Route('/', name: 'app_categorie_a_index', methods: ['GET'])]
    public function index(CategorieARepository $categorieARepository): Response
    {
        return $this->render('categorie_a/index.html.twig', [
            'categorie_as' => $categorieARepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_a_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategorieARepository $categorieARepository): Response
    {
        $categorieA = new CategorieA();
        $form = $this->createForm(CategorieAType::class, $categorieA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieARepository->save($categorieA, true);

            return $this->redirectToRoute('app_categorie_a_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_a/new.html.twig', [
            'categorie_a' => $categorieA,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_a_show', methods: ['GET'])]
    public function show(CategorieA $categorieA): Response
    {
        return $this->render('categorie_a/show.html.twig', [
            'categorie_a' => $categorieA,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_a_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieA $categorieA, CategorieARepository $categorieARepository): Response
    {
        $form = $this->createForm(CategorieAType::class, $categorieA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieARepository->save($categorieA, true);

            return $this->redirectToRoute('app_categorie_a_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_a/edit.html.twig', [
            'categorie_a' => $categorieA,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_a_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieA $categorieA, CategorieARepository $categorieARepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieA->getId(), $request->request->get('_token'))) {
            $categorieARepository->remove($categorieA, true);
        }

        return $this->redirectToRoute('app_categorie_a_index', [], Response::HTTP_SEE_OTHER);
    }
 

}
