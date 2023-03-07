<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/event')]
class EventController extends AbstractController
{
    //const COLOURS ;
    #[Route('/recherche', name: 'recherche')]
    public function rechercheEvent(EventRepository $repo, Request $request): Response
    {
        $search = $request->get('search');
        $list = $repo->recherche($search);
        return $this->render("event/index.html.twig", ['events' => $list]);
    }

    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/front', name: 'app_show', methods: ['GET'])]
    public function showf(EventRepository $eventRepository): Response
    {
        return $this->render('event/showF.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EventRepository $eventRepository, FlashyNotifier $flashy): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        //trecuperi les donnees mel form w elle remplit lobjet $event

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->save($event, true);
            //taawedh el persist + flush

            $flashy->success('Event created!', 'http://127.0.0.1:8000/event/');
            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EventRepository $eventRepository, FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->save($event, true);
            $flashy->mutedDark('Event updated!', 'http://127.0.0.1:8000/event/');
            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EventRepository $eventRepository, FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $eventRepository->remove($event, true);
        }
        $flashy->warning('Event deleted!', 'http://127.0.0.1:8000/event/');
        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/sortDate', name: 'app_date_event')]
    public function showByDate(EventRepository $repo)
    {
        $list = $repo->orderDate();
        return $this->render("event/index.html.twig", ['events' => $list]);
    }

    #[Route('/dates', name: 'app_2dates_event')]
    public function getBetweenDates(EventRepository $repo)
    {
        $list = $repo->findDateBetween();
        return $this->render("event/index.html.twig", ['events' => $list]);
    }
    #[Route('/stats', name: 'stats',methods: ['GET', 'POST'])]
    public function statistiques(EventRepository $repo): Response
    {


        $events = $repo->findAll();
        $eventName = [];
        $eventCount = [];

        foreach ($events as $event) {
            $eventName[] = $event->getNom();
            $eventCount[] = count($event->getTools());


        }
        /*
        neededColours = fergha
            for (i à juska lenght eventCount)
                neededColours = colour de i
        */
        return $this->render("event/stats.html.twig", [
            'eventName' => json_encode($eventName),
            'eventCount' => json_encode($eventCount)

        ]);
    }

}
