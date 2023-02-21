<?php

namespace App\Controller;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\ArticlesRepository;
use App\Repository\CommentairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commentaires')]
class CommentairesController extends AbstractController
{
    #[Route('/', name: 'app_commentaires_index', methods: ['GET'])]
    public function index(CommentairesRepository $commentairesRepository): Response
    {
        return $this->render('commentaires/index.html.twig', [
            'commentaires' => $commentairesRepository->findAll(),
        ]);
    }


   

    #[Route('/new', name: 'app_commentaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentairesRepository $commentairesRepository): Response
    {
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $commentaire->setDateCom(new \DateTime('now'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentairesRepository->save($commentaire, true);

            return $this->redirectToRoute('app_articles_index_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaires/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaires_show', methods: ['GET'])]
    public function show(Commentaires $commentaire): Response
    {
        return $this->render('commentaires/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaires $commentaire, CommentairesRepository $commentairesRepository): Response
    {
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentairesRepository->save($commentaire, true);

            return $this->redirectToRoute('app_articles_index_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaires/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaires_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaires $commentaire, CommentairesRepository $commentairesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $commentairesRepository->remove($commentaire, true);
        }

        return $this->redirectToRoute('app_articles_index_front', [], Response::HTTP_SEE_OTHER);
    }
  
  
}
