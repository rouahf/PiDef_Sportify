<?php

namespace App\Entity;

use App\Repository\PostLikeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostLikeRepository::class)]
class PostLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postLikes')]
    private ?Articles $articles = null;

    #[ORM\ManyToMany(targetEntity: Articles::class, inversedBy: 'postLikes')]
    private Collection $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Articles>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Articles $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
        }

        return $this;
    }

    public function removeLike(Articles $like): self
    {
        $this->likes->removeElement($like);

        return $this;
    }
}
