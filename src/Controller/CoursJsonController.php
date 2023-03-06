<?php

namespace App\Controller;


use App\Entity\Cours;
use App\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoursRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CoursJsonController extends AbstractController
{
    #[Route("/All", name: "cours_find")]
    public function find(NormalizerInterface $Normalizer,CoursRepository $coursRepository )
    {
        $repository= $this->getDoctrine()->getRepository(Cours::class);
        $cours = $coursRepository->findAll();
        $jsonContent = $Normalizer->normalize($cours,'json',['groups'=>'cours']);
        return new Response(json_encode($jsonContent));
    }
    
    #[Route("/ajout", name: "cours_ajout")]
    public function ajouter(Request $request,NormalizerInterface $Normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $Cours = new Cours();
        $Cours->setNomCours($request->get('nom_cours'));
        $Cours->setActivite($request->get('activite'));       
        $Cours->setDateCours(new \DateTime('@'.strtotime('Now')));
        $Cours->setImage($request->get('image'));
        $em->persist($Cours);
        $em->flush();
        $jsonContent = $Normalizer->normalize($Cours,'json',['groups'=>'cours']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/update/{id}", name: "update_cours")]
    public function UpdateCoursJSON($id,Request $request,NormalizerInterface $Normalizer)
    {
        $em= $this->getDoctrine()->getManager();
        $Cours = $this->getDoctrine()->getRepository(Cours::class)->find($id);
        $Cours->setNomCours($request->get('nom_cours'));
        $Cours->setActivite($request->get('activite'));       
        $Cours->setDateCours(new \DateTime('@'.strtotime('Now')));
        $Cours->setImage($request->get('image'));
        $em->persist($Cours);
        $em->flush();
        $jsonContent = $Normalizer->normalize($Cours,'json',['groups'=>'cours']);
        return new Response("Update successfully".json_encode($jsonContent));
    }
    #[Route("/delete/{id}", name: "delete_cours")]
    public function DeleteCoursJSON($id,Request $request,NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $Cours = $this->getDoctrine()->getRepository(Cours::class)->find($id);
        if($Cours!=null ) {
        $em->remove($Cours);
        $em->flush();
        $jsonContent = $Normalizer->normalize($Cours,'json',['groups'=>'cours']);
        return new Response("Delete successfully".json_encode($jsonContent));
        }else{
            return new JsonResponse("id cours invalide.");}
    }
}
