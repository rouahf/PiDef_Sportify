<?php

namespace App\Controller;


use App\Repository\PrioriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrioriteeController extends AbstractController
{
    #[Route('/prioritee', name: 'app_prioritee')]
    public function index(): Response
    {
        return $this->render('prioritee/index.html.twig', [
            'controller_name' => 'PrioriteeController',
        ]);
    }

    #[Route('/listeP', name: 'app_p')]
    public function getPriorite(PrioriteRepository $repo,SerializerInterface $serializerInterface): Response
    {
        $priorite=$repo->findAll();
        $json=$serializerInterface->serialize($priorite,'json',['groups'=>'priorite']);
        dump($priorite);
        die;

    }

    #[Route('/add', name: 'app_add')]
    public function addPriorite(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
    {
        $content=$request->getContent();
        $data=$serializer->deserialize($content,Priorite::class,'json');
        $em->persist($data);
        $em->flush();
        return new Response('added');

    }
}
