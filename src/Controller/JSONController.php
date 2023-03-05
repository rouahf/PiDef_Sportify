<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JSONController extends AbstractController
{
    #[Route('/json', name: 'app_json')]
    public function index(): Response
    {
        return $this->render('json/index.html.twig', [
            'controller_name' => 'JSONController',
        ]);
    }
    #[Route("/Alprod", name: "Productttt")]
    public function ProductId(ProductRepository $repo ,SerializerInterface $serializerInterface )
    {
        $product = $repo->findAll();
        $json=$serializerInterface->serialize($product,'json',['groups'=>'product']);
        dump($product);
        die;
    }
    #[Route("/Alcat", name: "category")]
    public function cat(CategoriesRepository $repo)
    {
        $product = $repo->findAll();
        dump($product);
        die;
    }

    #[Route('/addrJSON', name: 'addJSON')]
    public function addUserJSON(Request $req,   NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setNameProduct($req->get('nameProduct'));
        $product->setDescription($req->get('description'));
        $product->setMoreInformations($req->get('moreInformations'));
        $product->setPrice($req->get('price'));
       $product->setIsBest($req->get('isBest'));

        $product->setIsNew($req->get('isNew'));
      //  $product->setIsFeatured($req->get(0));
       
      //$product->setIsSpecialOffer($req->get(0));
        $product->setImage($req->get('image'));
        $product->setQuantity($req->get('quantity'));
        $product->setTags($req->get('tags'));
        $product->setSlug($req->get('slug'));
      //  $product->setCategory($req->get('Box'));

        $em->persist($product);
        $em->flush();

        $jsonContent = $Normalizer->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($jsonContent));
    }
    #[Route("/update/{id}", name: "update_prod")]
    public function UpdateCoursJSON($id,Request $req,NormalizerInterface $Normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
     
       
        $product->setNameProduct($req->get('nameProduct'));
        $product->setDescription($req->get('description'));
        $product->setMoreInformations($req->get('moreInformations'));
        $product->setPrice($req->get('price'));
       $product->setIsBest($req->get('isBest'));

        $product->setIsNew($req->get('isNew'));
      //  $product->setIsFeatured($req->get(0));
       
      //$product->setIsSpecialOffer($req->get(0));
        $product->setImage($req->get('image'));
        $product->setQuantity($req->get('quantity'));
        $product->setTags($req->get('tags'));
        $product->setSlug($req->get('slug'));
      //  $product->setCategory($req->get('Box'));

        $em->persist($product);
        $em->flush();
        $jsonContent = $Normalizer->normalize($product,'json',['groups'=>'product']);
        return new Response("Update successfully".json_encode($jsonContent));
    }
    #[Route("/delete/{id}", name: "delete_cours")]
    public function DeleteCoursJSON($id,Request $request,NormalizerInterface $Normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
     
        if($product!=null ) {
        $em->remove($product);
        $em->flush();
        $jsonContent = $Normalizer->normalize($product,'json',['groups'=>'product']);
        return new Response("Delete successfully".json_encode($jsonContent));
        }else{
            return new JsonResponse("id cours invalide.");}
    }
}

