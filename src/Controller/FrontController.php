<?php

namespace App\Controller;
use App\Entity\PostLike;
use App\Entity\SearchData;
use App\Form\SearchType;
use App\Entity\Articles;
use App\Entity\CategorieA;
use App\Entity\Commentaires;
use App\Form\ArticlesType;
use App\Form\CategorieAType;
use App\Form\CommentairesType;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Mapping\ClassMetadata;
use App\Repository\ArticlesRepository;
use App\Repository\CategorieARepository;
use App\Repository\CommentairesRepository;
use Dompdf\Dompdf;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\ChoiceList\IdReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/front')]
class FrontController extends AbstractController

{
    #[Route('/', name: 'app_articles_index_front', methods: ['GET', 'POST'])]
    public function index(Request $request, ArticlesRepository $articlesRepository, CategorieARepository $categorieARepository, CommentairesRepository $commentairesRepository, PaginatorInterface $paginator): Response
    { $articles = $articlesRepository->findAll();
       
        $articles = $paginator->paginate(
         $articles,$request->query->getInt('page',1),3

);
        // Render the template with the pagination
        return $this->render('front/index.html.twig', [
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
return $this->render('front/show_front.html.twig', [
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
        
        return $this->render('front/index.html.twig', [
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
    public function like(Articles $post , EntityManagerInterface $manager, PostLikeRepository $likeRepository ):Response
    {
          $user=$this->getUser();
 
       
 
          $like= new PostLike();
         $like->setArticles($post);
          $manager->persist($like);
          $manager->flush();
 
          return $this->json(['code'=> 200 ,
              'message'=> 'Like bien ajoutee',
              'likes'=>$likeRepository->count(['articles'=>$post])
          ],200);
 
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

    return $this->render('front/index.html.twig', [
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
}


   
  
