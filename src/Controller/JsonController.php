<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class JsonController extends AbstractController
{
    #[Route("/all", name: "event_find")]
    public function find(EventRepository $repo ,serializerInterface $serializerInterface )
    {
        $event = $repo->findAll();
        $json=$serializerInterface->serialize($event,'json',['groups'=>'event']);
        dump($event);
    die;
        //return new Response("json");
    }

    #[Route("/ajout", name: "event_ajout")]
    public function ajouter(Request $request,NormalizerInterface $Normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $event = new Event();
        $event->setNom($request->get('nom'));
        $event->setType($request->get('type'));
        $event->setDateEvent(new \DateTime('@'.strtotime('Now')));
        $em->persist($event);
        $em->flush();
        $jsonContent = $Normalizer->normalize($event,'json',['groups'=>'events']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/delete/{id}", name: "delete_event")]
    public function DeleteEventJSON($id,Request $request,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        if($event!=null ) {
            $em->remove($event);
            $em->flush();
            $jsonContent = $Normalizer->normalize($event,'json',['groups'=>'event']);
            return new Response("Delete successfully".json_encode($jsonContent));
        }else
        {
            return new JsonResponse("id cours invalide.");
        }
    }

    #[Route("/update/{id}", name: "update_event")]
    public function UpdateEventJSON($id,Request $request,NormalizerInterface $Normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        $event->setNom($request->get('nom'));
        $event->setType($request->get('type'));
        $event->setDateEvent(new \DateTime('@'.strtotime('Now')));
        $em->persist($event);
        $em->flush();
        $jsonContent = $Normalizer->normalize($event,'json',['groups'=>'event']);
        return new Response("Update successfully".json_encode($jsonContent));
    }





    /*
    #[Route('/json', name: 'app_json')]
    public function index(): Response
    {
        return $this->render('json/index.html.twig', [
            'controller_name' => 'JsonController',
        ]);
    }
    #[Route("/Alprod", name: "Event")]
    public function EventId(EventRepository $repo ,SerializerInterface $serializerInterface )
    {
        $product = $repo->findAll();
        $json=$serializerInterface->serialize($product,'json',['groups'=>'product']);
        dump($product);
        die;
    }

    #[Route('addUserJSON/new', name: 'addUserJSON')]
    public function addEventJson(Request $req,   NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $event = new Event();
        $event->setNom($req->get('nom'));
        $event->setType($req->get('type'));


        $em->persist($event);
        $em->flush();

        $jsonContent = $Normalizer->normalize($event, 'json', ['groups' => 'user']);
        return new Response(json_encode($jsonContent));
    }
*/


}
