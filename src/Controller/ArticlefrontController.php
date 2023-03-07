<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Articles;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\LikeRepository;
use Knp\Component\Pager\Paginator;
use App\Repository\ArticlesRepository;
use App\Repository\CategorieARepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentairesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/articlefront')]

class ArticlefrontController extends AbstractController
{
    #[Route('/', name: 'app_articles_index_front')]
    public function index(Request $request, ArticlesRepository $articlesRepository, CategorieARepository $categorieARepository, CommentairesRepository $commentairesRepository, PaginatorInterface $paginator): Response
    {
        $articles = $articlesRepository->findAll();
       
        $articles = $paginator->paginate(
         $articles,$request->query->getInt('page',1),3

);
        // Render the template with the pagination
        return $this->render('articlefront/index.html.twig', [
            'articles' => $articles,
            'categorie_as' => $categorieARepository->findAll(),
            'commentaires' => $commentairesRepository->findAll(),
            //'search' => $form->createView()
            
        ]);
}
#[Route('/{id}', name: 'app_articles_show_front')]
    public function show_article(Articles $article,$id,Request $request,CommentairesRepository $comment): Response
    {
        $comment = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $comment);

        $comment->setDateCom(new \DateTime('now'));
      
        $form->handleRequest($request);
      
        $entityManageree=$this->getDoctrine()->getManager();
        $post = $entityManageree->getRepository(Articles::class)->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setIdArticle($post);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('info', 'Comment Added Successfully !');
            return $this->redirectToRoute('app_articles_index_front', [], Response::HTTP_SEE_OTHER);

        }
$entityManagere = $this->getDoctrine()->getManager();
$post = $entityManagere->getRepository(Articles::class)->find($id);
return $this->render('articlefront/show_front.html.twig', [
    'titre_Article' => $post->getTitreArticle(),
    'image_Article' => $post->getImageArticle(),
    'contenu_Article' => $post->getContenuArticle(),
   
    'article' => $post,
    'Commentaires' => $post,
    'commentaire' =>$comment,
    'id' => $post->getId(),
    'form'=>$form->createView(),
    ]);
       /* return $this->render('front/show_front.html.twig', [
            'article' => $article,
            
        ]);*/
    }
    #[Route('/{id}', name: 'app_com_show_front', methods: ['GET'])]
    public function show_com(Commentaires $commentaire): Response
    {
        
        return $this->render('articlefront/index.html.twig', [
            'commentaire' => $commentaire
        ]);
    }
   /**
     * @Route ("/{id}/like",name="post_like")
     * @param Articles $post
     * @param EntityManagerInterface $manager
     * @param \App\Repository\PostLikeRepository $likeRepository
     * @return Response
     */
    public function like(Articles $post , EntityManagerInterface $manager, LikeRepository $likeRepository ):Response
    {
        $user=$this->getUser();
       // if (!$user) return $this->json(['code'=>403,'message'=>"unauthorized"],403);
      
        if ($user){
            $like=$likeRepository->findOneBy(['articles'=>$post , 'User'=>$user]);
            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code'=>200,
                'message'=>'Like bien supprimé',
                'likes' => $likeRepository->count(['articles'=>$post])
            ],200);
        }
    
        $like= new Like();
        $like->setArticles($post)->setUser($user);
        $manager->persist($like);
        $manager->flush();
        return $this->redirectToRoute('app_articles_index_front', [], Response::HTTP_SEE_OTHER);
    
        /*return $this->json(['code'=> 200 ,
            'message'=> 'Like bien ajoutee',
            'likes'=>$likeRepository->count(['articles'=>$post])
        ],200);*/
        
}
#[Route('/{id}', name: 'show_coments', methods: ['GET'])]

public function showComments(Request $request)
{
    $entityManager = $this->getDoctrine()->getManager();
    $commentRepository = $entityManager->getRepository(Commentaires::class);

    // Récupère les données du formulaire de recherche
    $searchTerm = $request->query->get('searchTerm');

    // Construit la requête SQL
    $qb = $commentRepository->createQueryBuilder('c');
    if ($searchTerm) {
        $qb->where('c.id_article LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%');
    }
    $query = $qb->getQuery();

    // Paginer les résultats
    $paginator = new Paginator($query);
    $pagination = $paginator->paginate($request->query->getInt('page', 1), 10);

    return $this->render('articlefront/index.html.twig', [
        'pagination' => $pagination,
        'searchTerm' => $searchTerm
    ]);
}


 /**
 * @Route("/comment/{id}/reply", name="comment_reply")
 * @param Request $request
 * @param Commentaires $comment
 * @return Response
 */
public function replyToComment(Request $request, Commentaires $comment): Response
{
    $replyForm = $this->createForm(CommentairesType::class);

    $replyForm->handleRequest($request);

    if ($replyForm->isSubmitted() && $replyForm->isValid()) {
        $reply = $replyForm->getData();
        $reply->setParentComment($comment);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reply);
        $entityManager->flush();
    }

    return $this->render('commentaires/new.html.twig', [
        'comment' => $comment,
        'form' => $replyForm->createView()
    ]);

    }
 /*   #[Route('/{id}/like', name: 'app_like', methods: ['POST'])]

    public function like(Articles $article, Request $request)
    {
        $article->setLikes($article->getLikes() + 1);
    
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
    
        $isArticleLiked = $this->getUser()->getLikes()->contains($article);
    
    
        return new JsonResponse(['likes' => $article->getLikes()]);
    }
    
    #[Route('/{id}/dislike', name: 'app_dislike', methods: ['POST'])]

    public function unlike(Articles $article, Request $request)
    {
        $article->setLikes($article->getLikes() - 1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->render('front/index.html.twig', [
            'article' => $article
        
        ]);
        return new JsonResponse(['likes' => $article->getLikes()]);
    }
    */
}


   
  
