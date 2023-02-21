<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @Route("/ind")
     */
    
#[Route('/ind')]
    public function index(PlanningRepository $planningRepository): JsonResponse
    {
        $events = $planningRepository->findAll();

        $data = [];

        foreach ($events as $event) {
            $data[] = [
                'id' => $event->getId(),
                'date_cours' => $event->getDateCours()->format('Y-m-d H:i:s'),
                'cours' => $event->getCours()->getNomCours()
            ];
        }

     

        return new JsonResponse($data);
    }
}
