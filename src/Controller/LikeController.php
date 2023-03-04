<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    #[Route('/like', name: 'app_like')]
    public function index(): Response
    {
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController',
        ]);
    }
    #[Route('/like/article/{id}', name: 'like.post', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function like(Articles $post, EntityManagerInterface $manager): Response
    {$user = $this->getUser();
        
        if ($user !== null && $post->isLikedByUser($user)) {
            $post->removeLike($user);
            $manager->flush();

            return $this->json([
                'message' => 'Le like a été supprimé.',
                'nbLike' => $post->howManyLikes()
            ]);
        }

        $post->addLike($user);
        $manager->flush();

        return $this->json([
            'message' => 'Le like a été ajouté.',
            'nbLike' => $post->howManyLikes()
        ]);
    }
}
