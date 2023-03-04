<?php

namespace App\Entity;

use App\Repository\PostLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostLikeRepository::class)]
class PostLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Likes')]
    private ?Articles $articles = null;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="Likes")
     */
    private $Client;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    private ?Articles $likes = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(?Articles $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function getLikes(): ?Articles
    {
        return $this->likes;
    }

    public function setLikes(?Articles $likes): self
    {
        $this->likes = $likes;

        return $this;
    }



   
}
