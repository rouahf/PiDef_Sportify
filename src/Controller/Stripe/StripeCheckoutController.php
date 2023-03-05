<?php

namespace App\Controller\Stripe;

use App\Entity\Cart;
use App\Services\OrderServices;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeCheckoutController extends AbstractController
{
    #[Route('/create-checkout-session/{reference}', name: 'create_checkout_session')]
    public function index(?Cart $cart, CartRepository $repoCart, OrderServices $orderServices, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        if(!$cart){
          return $this->redirectToRoute('accueil');
        }

        $order = $orderServices->createOrder($cart);
        Stripe::setApiKey($_ENV['key_test_stripe_secret']);
        
        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            "payment_method_types" => ['card'],
            'line_items' => $orderServices->getLineItems($cart),
            'mode' => 'payment',
            'success_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-cancel/{CHECKOUT_SESSION_ID}',
        ]);
        
        $order->setStripeSessionId($checkout_session->id);
        $manager->flush();
        
        return $this->json(['id' => $checkout_session->id]);
    }
}
