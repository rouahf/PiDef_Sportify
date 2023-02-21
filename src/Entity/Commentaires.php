<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentairesRepository::class)]
class Commentaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu_C = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_com = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Articles $id_article = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_C = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Email is required")]
    #[Assert\Email(message:"the email '{{ value }}' is not a valid email")]
    private ?string $email_c = null;


   


   
   

   

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

    public function getIdArticle(): ?Articles
    {
        return $this->id_article;
    }

    public function setIdArticle(?Articles $id_article): self
    {
        $this->id_article = $id_article;

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


  

   
   

}
