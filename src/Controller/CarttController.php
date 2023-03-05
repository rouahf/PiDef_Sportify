<?php

namespace App\Controller;

use App\Services\CartServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class CarttController extends AbstractController
{ private $cartServices;
    public function __construct(CartServices $cartServices)
    {
        $this->cartServices = $cartServices;
    }

    #[Route('/cartt', name: 'panier')]
    public function index(): Response
    {
        $cart = $this->cartServices->getFullCart();
        if (!isset($cart['products'])){
            return $this->redirectToRoute("accueil");
        }
        return $this->render('cartt/index.html.twig', [
            'cart' => $cart
        ]);
    }
    #[Route('/cartt/add/{id}', name: 'cartAdd')]

    public function addToCart($id): Response{
        //$cartServices->deleteCart();
        $this->cartServices->addToCart($id);
        //dd($cartServices->getFullCart());//test ok pour l'ajout
        return $this->redirectToRoute("panier");
        //return $this->render('cart/index.html.twig', [
           // 'controller_name' => 'CartController',]);
    }
    #[Route('/cartt/delete/{id}', name: 'cartDelete')]

    public function deleteFromCart($id): Response{
       
        $this->cartServices->deleteFromCart($id);
        //dd($cartServices->getFullCart());//test ok pour le delete
        return $this->redirectToRoute("panier");
        //return $this->render('cart/index.html.twig', [
        //    'controller_name' => 'CartController',]);
    }
    #[Route('/cartt/deleteAll/{id}', name: 'cartDeleteAll')]

    public function deleteAllToCart($id): Response{
       
        $this->cartServices->deleteAllToCart($id);
        //dd($cartServices->getFullCart());//test ok pour le delete
        return $this->redirectToRoute("panier");
        //return $this->render('cart/index.html.twig', [
        //    'controller_name' => 'CartController',]);
    }
}
