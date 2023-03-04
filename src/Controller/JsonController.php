<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\CategorieA;
use App\Entity\Commentaires;
use App\Repository\ArticlesRepository;
use App\Repository\CommentairesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonController extends AbstractController
{
    #[Route('/json', name: 'app_json')]
    public function index(): Response
    {
        return $this->render('json/index.html.twig', [
            'controller_name' => 'JsonController',
        ]);
    }
    /******************************crud Article avec JSON************************* */
    /***********affichage*************************************** */
    #[Route("/displayJson", name: "list")]
    public function getArticles(ArticlesRepository $repo, SerializerInterface $serializerInterface)
    {
        $articles = $repo->findAll();
        $json=$serializerInterface->serialize($articles,'json',['groups'=>'article']);
   return new Response($json);
    }
    /**********************affichage par id************* */
#[Route("/Article__json/{id}", name: "get_article")]
public function ArticleId($id,SerializerInterface $serializerInterface,ArticlesRepository $repo)
{
    $article = $repo->find($id);
    $json=$serializerInterface->serialize($article,'json',['groups'=>'article']);
   return new Response($json);
}
/***************Suppression d' un article******************* */
#[Route("/deleteArticle/{id}", name: "supp_Article")]
public function deleteArticlesJSON(Request $req ,$id,NormalizerInterface $Normalizer)
{
    $em=$this->getDoctrine()->getManager();
    $article =$em->getRepository(Articles::class)->find($id);
    $em->remove($article);
    $em->flush();
    $jsonContent = $Normalizer->normalize($article, 'json', ['groups' => 'article']);
    return new Response("Article deleted Successfully ".json_encode($jsonContent));

}
/******Update Article************* */
#[Route(" updateArticle/{id}", name: "updateJsonA")]
public function updateArticle(Request $request,$id,NormalizerInterface $Normalizer)
{
$em =  $this->getDoctrine()->getManager();
$article = $em->getRepository(Articles::class)->find($id);
$titre_Article = $request->get('titre_Article');
if ($titre_Article !== null) {
$article->setTitreArticle($titre_Article);
}
$image_article = $request->get('image_article');

if ($image_article !== null) {
$article->setImageArticle($image_article);
}
$auteur_article = $request->get('auteur_Article');

if ($auteur_article!== null) {
$article->setAuteurArticle($request->get('auteur_Article'));
}
$contenu_Article= $request->get('contenu_Article');

if($contenu_Article !==null){
$article->setContenuArticle($request->get('contenu_Article'));
}

//$article->setIdCategA($request->get('id_categA'));
$article->setDateA(new \DateTime('@'.strtotime('Now')));
$em->flush();
$jsonContent = $Normalizer->normalize($article,'json',['groups' =>'article']);
return new Response("articles update successfully " .json_encode($jsonContent));


}
 /***********ajouter un article******* */
 #[Route("/ajout_article_json/new", name: "ajout_article")]
 public function addArticleJSON( Request $request,SerializerInterface $serializer ,EntityManagerInterface $em,NormalizerInterface $Normalizer)
 {
    
     $article=new Articles();
     $date= new \DateTime('now');
     $titre_Article = $request->get('titre_Article');

     if ($titre_Article !== null) {
         $article->setTitreArticle($titre_Article);
         }
         $image_article = $request->get('image_article');
         
         if ($image_article !== null) {
         $article->setImageArticle($image_article);
         }
         $auteur_article = $request->get('auteur_Article');
         
         if ($auteur_article!== null) {
         $article->setAuteurArticle($request->get('auteur_Article'));
         }
         $contenu_Article= $request->get('contenu_Article');
         
         if($contenu_Article !==null){
         $article->setContenuArticle($request->get('contenu_Article'));
         }
         $id_categ_a_id = $request->get('id_categ_A');

         if ($id_categ_a_id !== null) {
             $category = $em->getRepository(CategorieA::class)->find($id_categ_a_id);
             if ($category !== null) {
                 $article->setIdCategA($category);
             }
         }
         $article->setDateA(new \DateTime('@'.strtotime('Now')));
     $em->persist($article);
     $em->flush();

     $jsonContent=$Normalizer->normalize($article,'json',['groups'=>'article']);
     return new Response(json_encode($jsonContent));
 }


/************************crud Commentaire avec JSON*********************************************** */
     /***********affichage commentaires*************************************** */
     #[Route("/displaycomJson", name: "list_com")]
     public function getCommentaires(CommentairesRepository $repo, SerializerInterface $serializerInterface)
    {
        $commentaire = $repo->findAll();
        $json=$serializerInterface->serialize($commentaire,'json',['groups' => 'commentaire']);
        return new Response($json);
    }
    
   
/**ajouter un commentaire avec json**** */
#[Route("/add_com", name: "ajout_com")]
public function AddCommentaires(CommentairesRepository $repo, SerializerInterface $serializerInterface, Request $request,SerializerInterface $serializer ,EntityManagerInterface $em,NormalizerInterface $Normalizer)
{
   $commentaire=new Commentaires();
   $nom_C = $request->get('nom_C');

   if ($nom_C !== null) {
       $commentaire->setNomC($nom_C);
       }
       $contenu_C = $request->get('contenu_C');
       
       if ($contenu_C!== null) {
       $commentaire->setContenuC($contenu_C);
       }
       $email_c = $request->get('email_c');
       
       if ($email_c!== null) {
       $commentaire->setEmailC($request->get('email_c'));
       }
    $id_article_id  = $request->get('id_article');

if ($id_article_id !== null) {
    $article = $em->getRepository(Articles::class)->find($id_article_id);

    if ($article !== null) {
        $commentaire->setIdArticle($article);
    }
}
       
    $commentaire->setDateCom(new \DateTime('@'.strtotime('Now')));
   $em->persist($commentaire);
   $em->flush();

   $jsonContent=$Normalizer->normalize($commentaire,'json',['groups'=>'commentaire']);
   return new Response(json_encode($jsonContent));

}
/******Update commentaire************* */
#[Route(" updateACom/{id}", name: "updateJsonC")]
public function updateCom(Request $request,$id,NormalizerInterface $Normalizer)
{
$em =  $this->getDoctrine()->getManager();
$commentaire = $em->getRepository(Commentaires::class)->find($id);
$nom_C= $request->get('nom_C');
if ($nom_C !== null) {
$commentaire->setNomC($nom_C);
}
$email_c = $request->get('email_c');

if ($email_c !== null) {
$commentaire->setEmailC($email_c);
}
$contenu_c= $request->get('contenu_c');

if ($contenu_c!== null) {
    $commentaire->setContenuC($contenu_c);
}

$id_article_id  = $request->get('id_article');

if ($id_article_id !== null) {
    $article = $em->getRepository(Articles::class)->find($id_article_id);

    if ($article !== null) {
        $commentaire->setIdArticle($article);
    }
}

$commentaire->setDateCom(new \DateTime('@'.strtotime('Now')));
$em->flush();
$jsonContent = $Normalizer->normalize($commentaire,'json',['groups' =>'commentaire']);
return new Response("commentaire update successfully " .json_encode($jsonContent));


}
#[Route("/com_getid__json/{id}", name: "get_id_com")]
public function comId($id,SerializerInterface $serializerInterface,CommentairesRepository $repo)
{
    $com= $repo->find($id);
    $json=$serializerInterface->serialize($com,'json',['groups'=>'commentaire']);
   return new Response($json);
}
#[Route("/deleteCom/{id}", name: "supp_Com")]
public function deleteComJSON(Request $req ,$id,NormalizerInterface $Normalizer)
{
    $em=$this->getDoctrine()->getManager();
    $com=$em->getRepository(Commentaires::class)->find($id);
    $em->remove($com);
    $em->flush();
    $jsonContent = $Normalizer->normalize($com, 'json', ['groups' => 'commentaire']);
    return new Response("Commentaire deleted Successfully ".json_encode($jsonContent));

}
}