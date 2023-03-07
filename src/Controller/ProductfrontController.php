<?php

namespace App\Controller;

use App\Entity\Product;
use Endroid\QrCode\QrCode;
use App\Entity\SearchProduct;
use App\Form\SearchProductType;
use Endroid\QrCode\Writer\PngWriter;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductfrontController extends AbstractController
{
    #[Route('/productfront', name: 'app_productfront')]
    public function index(ProductRepository $repoProduct, Request $request): Response
    {
        $products = $repoProduct->findAll();
        $productBest = $repoProduct->findByIsBest(1);
        $productNew = $repoProduct->findByIsNew(1);
        $productFeatured = $repoProduct->findByIsFeatured(1);
        $productSpecialOffer = $repoProduct->findByIsSpecialOffer(1);
        
           //vider le formulaire
           $search = new SearchProduct();//Entity sans enregistrement dans la BD
           $form = $this->createForm(SearchProductType::class, $search);//il faut encapsuler les choix du formulaire dans une entité sans reporitory, objet métier
           //quand le formulaire est soumis
           $form->handleRequest($request);
           if($form->isSubmitted() && $form->isValid()){
               //$data = $form->getData();
               $products = $repoProduct->findWithSearch($search);
               //dd($data);
               //dd($search);
           }
        
        return $this->render('productfront/index.html.twig', [
            'controller_name' => 'ProductfrontController',
            'products' => $products,
            'productBest' => $productBest,
            'productNew' => $productNew,
            'productFeatured' => $productFeatured,
            'productSpecialOffer' => $productSpecialOffer,
             'search' => $form->createView()

        ]);
    }
    #[Route('/product/{slug}', name: 'product_details')]
    public function show(?Product $product): Response{
        
        if(!$product){
            return $this->redirectToRoute("app_productfront");
        }

        return $this->render("productfront/single_product.html.twig",[
            'product' => $product
        ]);
    }
    public function getQrCodeForProduct(int $id): Response
    {
        // Récupérer les informations du compte bancaire à partir de la base de données
        $pr = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!$pr) {
            throw $this->createNotFoundException('Le  produit  n\'existe pas');
        }

        // Générer le code QR à partir des informations du compte bancaire
        $qrCode = new QrCode($pr->getNameProduct());
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        $pngWriter = new PngWriter();
        $qrCodeResult = $pngWriter->write($qrCode);

         // Générer la réponse HTTP contenant le code QR
         $response = new QrCodeResponse($qrCodeResult);
         $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
             ResponseHeaderBag::DISPOSITION_ATTACHMENT,
             'qr_code.png'
         ));
 

        return $response;
    }
    /*
    #[Route('/shop', name: 'boutique')]

    public function shop(ProductRepository $repoProduct, Request $request): Response
    {
        $products = $repoProduct->findAll();

        //vider le formulaire
        $search = new SearchProduct();//Entity sans enregistrement dans la BD
        $form = $this->createForm(SearchProductType::class, $search);//il faut encapsuler les choix du formulaire dans une entité sans reporitory, objet métier
        //quand le formulaire est soumis
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$data = $form->getData();
            $products = $repoProduct->findWithSearch($search);
            //dd($data);
            //dd($search);
        }

        return $this->render('accueil/index.html.twig',[
            'products' => $products,
            'search' => $form->createView()
        ]);
    }
    */
}
