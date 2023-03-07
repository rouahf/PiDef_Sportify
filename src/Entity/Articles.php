<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre_Article = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu_Article = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur_Article = null;

    #[ORM\Column(length: 255)]
    private ?string $image_article = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_A = null;

    #[ORM\ManyToOne(inversedBy: 'id_categA')]
    private ?CategorieA $id_categA = null;

    #[ORM\OneToMany(mappedBy: 'id_article', targetEntity: Commentaires::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'articles', targetEntity: Like::class)]
    private Collection $likes;

    #[ORM\OneToMany(mappedBy: 'articles', targetEntity: PostLike::class)]
    private Collection $postLikes;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->postLikes = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreArticle(): ?string
    {
        return $this->titre_Article;
    }

    public function setTitreArticle(string $titre_Article): self
    {
        $this->titre_Article = $titre_Article;

        return $this;
    }

    public function getContenuArticle(): ?string
    {
        return $this->contenu_Article;
    }

    public function setContenuArticle(string $contenu_Article): self
    {
        $this->contenu_Article = $contenu_Article;

        return $this;
    }

    public function getAuteurArticle(): ?string
    {
        return $this->auteur_Article;
    }

    public function setAuteurArticle(string $auteur_Article): self
    {
        $this->auteur_Article = $auteur_Article;

        return $this;
    }

    public function getImageArticle(): ?string
    {
        return $this->image_article;
    }

    public function setImageArticle(string $image_article): self
    {
        $this->image_article = $image_article;

        return $this;
    }

    public function getDateA(): ?\DateTimeInterface
    {
        return $this->date_A;
    }

    public function setDateA(\DateTimeInterface $date_A): self
    {
        $this->date_A = $date_A;

        return $this;
    }


    public function getIdCategA(): ?CategorieA
    {
        return $this->id_categA;
    }

    public function setIdCategA(?CategorieA $id_categA): self
    {
        $this->id_categA = $id_categA;

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setIdArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdArticle() === $this) {
                $commentaire->setIdArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setArticles($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getArticles() === $this) {
                $like->setArticles(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostLike>
     */
    public function getPostLikes(): Collection
    {
        return $this->postLikes;
    }

    public function addPostLike(PostLike $postLike): self
    {
        if (!$this->postLikes->contains($postLike)) {
            $this->postLikes->add($postLike);
            $postLike->setArticles($this);
        }

        return $this;
    }

    public function removePostLike(PostLike $postLike): self
    {
        if ($this->postLikes->removeElement($postLike)) {
            // set the owning side to null (unless already changed)
            if ($postLike->getArticles() === $this) {
                $postLike->setArticles(null);
            }
        }

        return $this;
    }
}
