<?php

namespace App\Controller\Stripe;

use App\Entity\Orders;
use App\Services\CartServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeSuccessPaymentController extends AbstractController
{
    #[Route('/stripe-payment-success/{StripeSessionId}', name: 'stripe_payment_success')]
    public function index(?Orders $order, CartServices $cartServices, EntityManagerInterface $manager): Response
    {
        //dd($order);
        if(!$order || $order->getUser() !== $this->getUser()){
            return $this->redirectToRoute('accueil');
        }
        if(!$order->getIsPaid()){
            //commande est payée
            $order->setIsPaid(true);
            $manager->flush();

            $cartServices->deleteCart();
            //envoi d'un email au client
        }
        return $this->render('/stripe_success_payment/index.html.twig', [
            'controller_name' => 'StripeSuccessPaymentController',
            'order' => $order,
           
        ]);
    }
}
