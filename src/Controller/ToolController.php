<?php

namespace App\Controller;

use App\Entity\Tool;
use App\Form\ToolType;
use App\Repository\ToolRepository;
use Doctrine\Persistence\ManagerRegistry;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tool')]
class ToolController extends AbstractController
{
    #[Route('/', name: 'app_tool_index', methods: ['GET'])]
    public function index(ToolRepository $toolRepository): Response
    {
        return $this->render('tool/index.html.twig', [
            'tools' => $toolRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tool_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ToolRepository $toolRepository,FlashyNotifier $flashy): Response
    {
        $tool = new Tool();
        $form = $this->createForm(ToolType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $toolRepository->save($tool, true);
            $flashy->success('Tool created!', 'http://127.0.0.1:8000/tool/');
            return $this->redirectToRoute('app_tool_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tool/new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tool_show', methods: ['GET'])]
    public function show(Tool $tool): Response
    {
        return $this->render('tool/show.html.twig', [
            'tool' => $tool,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tool_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tool $tool, ToolRepository $toolRepository,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(ToolType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $toolRepository->save($tool, true);
            $flashy->mutedDark('Tool updated!', 'http://127.0.0.1:8000/tool/');
            return $this->redirectToRoute('app_tool_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tool/edit.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tool_delete', methods: ['POST'])]
    public function delete(Request $request, Tool $tool, ToolRepository $toolRepository,FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tool->getId(), $request->request->get('_token'))) {
            $toolRepository->remove($tool, true);
        }
        $flashy->warning('Tool deleted!', 'http://127.0.0.1:8000/tool/');
        return $this->redirectToRoute('app_tool_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/remove2/{id}', name: 'app_remove2_tool')]
    public function remove2Tool(ManagerRegistry $doctrine, Tool $t,FlashyNotifier $flashy): Response
    {
        $repo=$doctrine->getRepository(Tool::class);
        $repo->remove($t,true);
        $flashy->warning('Tool deleted!', 'http://127.0.0.1:8000/tool/');
        return  $this->redirectToRoute('app_tool_index');
    }
    #[Route('/front', name: 'app_event_show', methods: ['GET'])]
    public function showf(ToolRepository $toolRepository): Response
    {
        return $this->render('tool/showF.html.twig', [
            'tools' => $toolRepository->findAll(),
        ]);
    }
}
