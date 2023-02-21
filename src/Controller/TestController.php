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
class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }


     /**
     * @Route("/{idProduit}/test/shop", name="shop_single", methods={"POST","GET"})
     */
    public function shop(Request $request): Response
    {

        $id = $request->get("idProduit");
        $produit = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $Panier = new Panier();
        $session=$request->getSession();
        $a=$session->get("adress_email");
        $user2=$this->getDoctrine()->getRepository(User::class)->findOneBy(
            ['adress_email' => $a],
        );

        $form = $this->createForm(PanierType::class, $Panier);
        $form->add("Ajouter",SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
                
                $Commande = new Commande();
                $form = $this->createForm(CommandeType::class, $Commande);
                $Commande->setDateC(new \DateTime('now'));
                //$Commande->setCin($user2['cin']->getCin());
            // $Commande->setCin(User::class->getId());
            // $commande->setDateC(new \DateTime('now'));
              $Commande->setDateex(new \DateTime('now'));

                $this->ajouterCommande($Commande);

                
                    $Panier->setCommande($Panier->getCommande());
                    $Panier->setProduit($Panier->getProduit());
                    $Panier->setPrixU($produit->getPrix());
                



                $this->ajouterPanier($Panier);
          
                $Panier->setCommande($Panier->getCommande());
                $Panier->setProduit($Panier->getProduit());
                $Panier->setPrixU($produit->getPrix());
            
                  //  $Panier->setStatus('En cours');
                
                $this->ajouterPanier($Panier);
            }


           // return $this->redirectToRoute('cart');
        


        return $this->render('test/index.html.twig', [
            'produit' => $produit,
            'quatite' => 1,
            'form'=>$form->createView(),

        ]);

    }


    /**
     * @Route("/front/cart", name="cart", methods={"GET"})
     */
    public function cart(Request $request): Response
    { $session=$request->getSession();
        $a=$session->get("adress_email");
        $user2=$this->getDoctrine()->getRepository(User::class)->findOneBy(
            ['adress_email' => $a],
        );
        $Panier = new Panier();

        $idPanier = 0;
      
            $idPanier = $Panier->getCommande();
        

        $commandes = $this->Afficher_Panier($idPanier);

        return $this->render('cart/index.html.twig',[
            'commandes'=>$commandes,
        ]);

    }
   
    /**
     * @Route("/{idProduit}{quant}/front/cart", name="addcart", methods={"GET"})
     */
    public function addcart(Request $request): Response
    {
        $id = $request->get("idProduit");
        $quatite = $request->get("quat");
        $this->addFlash('success', 'Article ajouter avec succée! id '.$id.' quant '.$quatite);


        return $this->render('cart/index.html.twig');

    }

    /**
     * @Route("/{idCommande}/front/delete", name="delete_commande", methods={"GET"})
     */
    public function delete(Request $request): Response
    {$session=$request->getSession();
        $a=$session->get("adress_email");
        $user2=$this->getDoctrine()->getRepository(User::class)->findOneBy(
            ['adress_email' => $a],
        );
        $id = $request->get("idCommande");
        $this->supprimerCommande($id);

        $idPanier = 0;
        foreach($this->verifPanier($user2->getCin()) as $key => $value)
        {
            $idPanier = $value->getIdPanier();
        }

        $commandes = $this->Afficher_Commande($idPanier);

        return $this->render('cart/index.html.twig',[
            'commandes'=>$commandes,
        ]);

    }

   

    public function Afficher_Produit()
    {
        $liste = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $liste;
    }


    public function Afficher_Panier($id)
    {
        $liste = $this->getDoctrine()->getRepository(Panier::class)
            ->findBy([
                'id'=>$id,
            ]);
        return $liste;
    }


    public function verifPanier($id_usr)
    {
        $liste = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->findBy([
                'cin' => $id_usr,
                
            ]);

        return $liste;
    }

    public function ajouterCommande($Commande)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Commande);
        $entityManager->flush();
    }

    public function modifierPanier($id)
    {
        $panier = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        $panier->setStatusPanier('Payer');

        $em = $this->getDoctrine()->getManager();
        $em->flush();
    }



    public function ajouterPanier($Panier)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Panier);
        $entityManager->flush();
    }

    public function modifierCommande()
    {}

    public function supprimerPanier($id)
    {
        $Panier = $this->getDoctrine()->getRepository(Panier::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($Panier);
        $em->flush();
    }

   

    public function calcueTotale($idPanier)
    {
        $totale = 0;
        $liste = $this->Afficher_Panier($idPanier);

        foreach($liste as $key => $value)
        {
            $totale = ($value->getQuatite() * $value->getPrixU()) + $totale;
        }

        return $totale;
    }

    public function getProduit($id)
    {
        return $this->getDoctrine()->getRepository(Product::class)->find($id);
    }

    public function modifierQuantiter($id)
    {
        $commandes = $this->Afficher_Panier($id);

        foreach($commandes as $key => $commande)
        {
            $idProduit = $commande->getIdProduit();
            $produit = $this->getProduit($idProduit);

            $quant = 0;
            $quant = $produit->getQuatite() - $commande->getQuatite();
            $produit->setQuatite($quat);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
    }



}
