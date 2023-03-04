<?php

namespace App\Entity;

use App\Repository\CategorieARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieARepository::class)]
class CategorieA
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeA = null;

    #[ORM\OneToMany(mappedBy: 'id_categA', targetEntity: Articles::class)]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeA(): ?string
    {
        return $this->typeA;
    }

    public function setTypeA(string $typeA): self
    {
        $this->typeA = $typeA;

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setIdCategA($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getIdCategA() === $this) {
                $article->setIdCategA(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->typeA;
    }

}
