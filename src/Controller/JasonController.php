<?php

namespace App\Controller;

use App\Entity\Reclamationn;
use App\Repository\TypeRepository;
use App\Repository\PrioriteRepository;
use  Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReclamationnRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Serializer\Normalizer\NormalizableInterface;




class JasonController extends AbstractController
{
    #[Route('/jason', name: 'app_jason')]
    public function index(): Response
    {
        return $this->render('jason/index.html.twig', [
            'controller_name' => 'JasonController',
        ]);
    }

    #[Route("/Allll", name: "Productttt")]
    public function ProductId(ReclamationnRepository $repo)
    {
        $reclamationn = $repo->findAll();
        dump($reclamationn);
        die;
    }

    #[Route("/roua", name: "montype")]
    public function type(TypeRepository $repo)
    {
        $$reclamationn = $repo->findAll();
        dump($reclamationn);
        die;
    }

    #[Route("/r", name: "mapriorite")]
    public function priorite(PrioriteRepository $repo)
    {
        $reclamationn= $repo->findAll();
        dump($reclamationn);
        die;
    }

    #[Route("/ajout", name: "app_ajout")]
    public function ajouter(Request $request,NormalizerInterface $Normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $reclamation = new Reclamationn();
        $reclamation->setIdUser($request->get('idUser'));
        $reclamation->setEmail($request->get('email'));       
        $reclamation->setCategorie($request->get('categorie'));
        $reclamation->setEtatReclamation($request->get('etat_reclamation'));
        $reclamation->setPriorite($request->get('priorite'));

        $em->persist($reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize( $reclamation,'json',['groups'=>'reclamationn']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/delete/{id}", name: "delete_rec")]
    public function DeleterecJSON($id,Request $request,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getRepository(Reclamationn::class)->find($id);
        if( $reclamation!=null ) {
        $em->remove( $reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize( $reclamation,'json',['groups'=>'reclamationn']);
        return new Response("Delete successfully".json_encode($jsonContent));
        }else{
            return new JsonResponse("id reclamation invalide.");}
    }

  #[Route("/update/{id}", name: "update_reclamation")]
    public function UpdateJSON($id,Request $request,NormalizerInterface $Normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getRepository(Reclamationn::class)->find($id);
        $reclamation->setIdUser($request->get('idUser'));
        $reclamation->setEmail($request->get('email'));       
        $reclamation->setCategorie($request->get('categorie'));
        $reclamation->setEtatReclamation($request->get('etat_reclamation'));
        $reclamation->setPriorite($request->get('priorite'));

        $em->persist( $reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reclamation,'json',['groups'=>'reclamationn']);
        return new Response("Update successfully".json_encode($jsonContent));
    }


    #[Route("/aff", name: "afficher_reclamation")]
    public function afficherRecJSON()
    {
       $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamationn::class)->findAll();
       $serializer = new Serializer([new ObjectNormalizer()]);
       $formatted = $serializer->normalize($reclamation);
       
       return new JsonResponse($formatted);

    }

}



