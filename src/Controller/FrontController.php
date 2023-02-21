<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\PanierType;
use App\Form\CommandeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Panier;
use App\Entity\Commande;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;

class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front')]
    public function index(CategoryRepository $CategoryRepository): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $product = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('front/index.html.twig', [
            'categories'=>  $categories,
            'product'=>  $product,
        ]);
    }
       

 
    /**
     * @Route("/{idProduit}/front/shop", name="shop_single", methods={"POST","GET"})
     */
    public function add( Request $request)
    {
        
        $id = $request->get("idProduit");
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $panier = new Panier();
        $session=$request->getSession();
        $a=$session->get("adress_email");
        $user2=$this->getDoctrine()->getRepository(\App\Entity\User::class)->findOneBy(
            ['adress_email' => $a],
        );

        //$form = $this->createForm(CommandeType::class, null, [
          //  'cin' => $this->getCin()
       // ]);
       $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();

            // Enregistrer ma commande Order()
            $order = new Commande();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setUser($this->getUser());
           // $order->setCreatedAt($date);

            $this->entityManager->persist($order);

            // Enregistrer mes produits OrderDetails()
            foreach ($cart->getFull() as $product) {
                $orderDetails = new Panier();
                $orderDetails->setCommande($order);
                $orderDetails->setProduit($product['product']->getNameProduits());
                $orderDetails->setQuatite($product['quatity']);
                $orderDetails->setStatut($product['Statut']);
                $orderDetails->setPrixU($product['product']->getPrix());
                $orderDetails->setTotal($product['product']->getPrix() * $product['quantity']);
                $this->entityManager->persist($orderDetails);
            }

            $this->entityManager->flush();

            return $this->render('cart/test.html.twig', [
                'product' => $product,
             
            ]);
        }

        return $this->redirectToRoute('app_cart');
    }
}
