<?php

namespace App\DataFixtures;
use App\Repository\UtilisateurRepository;
use App\Repository\ArticlesRepository;
use App\Entity\Articles;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class PostFixtures extends Fixture
{ 
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 150; $i++) {
            $post = new Articles();
            $post->setTitreArticle($faker->words(4, true))
                ->setContenuArticle($faker->realText(1800))
                ->setAuteurArticle($faker->realText(1800));
                //->setState(mt_rand(0, 2) === 1 ? Articles::STATES[0] : Articles::STATES[1]);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
