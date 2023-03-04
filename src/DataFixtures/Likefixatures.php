<?php

namespace App\DataFixtures;
use App\Repository\UtilisateurRepository;
use App\Repository\ArticlesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Likefixatures extends Fixture
{ public function __construct(
    private ArticlesRepository $postRepository,
    private UtilisateurRepository $userRepository
) {
}
public function load(ObjectManager $manager): void
{
    $users = $this->userRepository->findAll();
    $posts = $this->postRepository->findAll();

    foreach ($posts as $post) {
        for ($i = 0; $i < mt_rand(0, 15); $i++) {
            $post->addLike(
                $users[mt_rand(0, count($users) - 1)]
            );
        }
    }

    $manager->flush();
}

public function getDependencies(): array
{
    return [
        UtilisateurFixatures::class,
        PostFixtures::class
    ];
}
}
