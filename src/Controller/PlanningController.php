<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Entity\Cours;
use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/planning')]
class PlanningController extends AbstractController
{
    #[Route('/cal', name: 'app_cal', methods: ['GET'])]
    public function cal(PlanningRepository $planningRepository)
    {
        $events = $planningRepository->findAll();

        $rdvs = [];

        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getDateCours()->format('Y-m-d H:i:s'),
                'end' => $event->getDateCours()->format('Y-m-d H:i:s'),
                'title' => $event->getCours()->getNomCours()    
            ];
        }

     

        $data = json_encode($rdvs);

        return $this->render('planning/showF.html.twig', compact('data'));
    }


    #[Route('/', name: 'app_planning_index', methods: ['GET'])]
    public function index(PlanningRepository $planningRepository): Response
    {
        return $this->render('planning/index.html.twig', [
            'plannings' => $planningRepository->findAll(),
        ]);
    }
   

    #[Route('/new', name: 'app_planning_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlanningRepository $planningRepository , MailerInterface $mailer): Response
    {
        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planningRepository->save($planning, true);

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
            
            
            
            $message = (new TemplatedEmail())
                //ili bech yeb3ath
                ->from('Sportify.planning@gmail.com')
                //ili bech ijih l message
                ->to("maher.karoui@esprit.tn")
                ->subject("new planning")
                ->html("<p>bonjour,". $planning->getCours()->getNomCours()."</p> votre cours  Merci pour votre Confiance </p>");
                
            
            /*$message = (new \Swift_Message('new planning'))
            //ili bech yeb3ath
            ->setFrom('Planning.Sportify@gmail.com')
            //ili bech ijih l message
            ->setTo("maher.karoui@esprit.tn")
            ->setBody("<p>bonjour,". $planning->getCours()->getNomCours()."</p> votre cours  Merci pour votre Confiance </p>");*/
        
        //on envoi l email
        $mailer->send($message);
        $this->addFlash('message','votre e-mail a bien ??t?? envoy??');
        
        }

        return $this->renderForm('planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planning_show', methods: ['GET'])]
    public function show(Planning $planning): Response
    {
        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_planning_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planning $planning, PlanningRepository $planningRepository): Response
    {
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planningRepository->save($planning, true);

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planning_delete', methods: ['POST'])]
    public function delete(Request $request, Planning $planning, PlanningRepository $planningRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planning->getId(), $request->request->get('_token'))) {
            $planningRepository->remove($planning, true);
        }

        return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
    }
  
}
