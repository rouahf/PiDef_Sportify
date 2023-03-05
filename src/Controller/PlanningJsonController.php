<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningJsonController extends AbstractController
{
    #[Route('/planning/json', name: 'app_planning_json')]
    public function index(): Response
    {
        return $this->render('planning_json/index.html.twig', [
            'controller_name' => 'PlanningJsonController',
        ]);
    }
}
