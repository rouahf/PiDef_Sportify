<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Entity\CategorieA;
use App\Form\CategorieAType;
use App\Repository\CategorieARepository;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Request;


#[Route('/front')]
class FrontController extends AbstractController

{
   
    #[Route('/', name: 'app_articles_index_front', methods: ['GET'])]
    public function index( ArticlesRepository $articlesRepository ,CategorieARepository $categorieARepository, CommentairesRepository  $commentairesRepository
   ): Response
{ 
return $this->render('front/index.html.twig', [
'articles' => $articlesRepository->findAll(),
'categorie_as' => $categorieARepository->findAll(),
'commentaires' => $commentairesRepository->findAll(),

]);

}

    #[Route('/{id}', name: 'app_articles_show_front', methods: ['GET'])]
    public function show_article(Articles $article): Response
    {
        
        return $this->render('front/show_front.html.twig', [
            'article' => $article,
        ]);
    }
    #[Route('/{id}', name: 'app_com_show_front', methods: ['GET'])]
    public function show_com(Commentaires $commentaire): Response
    {
        
        return $this->render('front/index.html.twig', [
            'commentaire' => $commentaire
        ]);
    }
   
    }
   
  
