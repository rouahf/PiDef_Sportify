<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentairesRepository::class)]
class Commentaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu_C = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_com = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_C = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Email is required")]
    #[Assert\Email(message:"the email '{{ value }}' is not a valid email")]
    private ?string $email_c = null;

    #[ORM\Column(nullable: true)]
    private ?bool $approved = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Articles $id_article = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenuC(): ?string
    {
        return $this->contenu_C;
    }

    public function setContenuC(string $contenu_C): self
    {
        $this->contenu_C = $contenu_C;

        return $this;
    }

    public function getDateCom(): ?\DateTimeInterface
    {
        return $this->date_com;
    }

    public function setDateCom(\DateTimeInterface $date_com): self
    {
        $this->date_com = $date_com;

        return $this;
    }

    public function getNomC(): ?string
    {
        return $this->nom_C;
    }

    public function setNomC(string $nom_C): self
    {
        $this->nom_C = $nom_C;

        return $this;
    }

    public function getEmailC(): ?string
    {
        return $this->email_c;
    }

    public function setEmailC(string $email_c): self
    {
        $this->email_c = $email_c;

        return $this;
    }

    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function getIdArticle(): ?Articles
    {
        return $this->id_article;
    }

    public function setIdArticle(?Articles $id_article): self
    {
        $this->id_article = $id_article;

        return $this;
    }
}
