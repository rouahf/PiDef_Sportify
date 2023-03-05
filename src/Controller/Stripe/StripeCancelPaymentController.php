<?php

namespace App\Controller\Stripe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class StripeCancelPaymentController extends AbstractController
{
    #[Route('stripe-payment-cancel/{StripeSessionId}', name: 'stripe_payment_cancel')]
    public function index(): Response
    {
        if(!$order || $order->getUser() !== $this->getUser()){
            return $this->redirectToRoute("accueil");
        }

        return $this->render('stripe/stripe_cancel_payment/index.html.twig', [
            'controller_name' => 'StripeCancelPaymentController',
            'order' => $order
        ]);
    }
}
