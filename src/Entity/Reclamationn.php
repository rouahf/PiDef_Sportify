<?php

namespace App\Entity;

use App\Repository\ReclamationnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationnRepository::class)]
#[Assert\NotBlank(message:"NotBlank")]
class Reclamationn
{
    #[ORM\Id]
    #[Assert\NotBlank(message:"NotBlank")]
    #[ORM\GeneratedValue]
    #[Assert\NotBlank(message:"NotBlank")]
    #[ORM\Column]
    #[Assert\NotBlank(message:"NotBlank")]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"NotBlank")]
    private ?int $idUser = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"Merci de taper votre adresse mail")]
    #[Assert\Email(message:"***@***.***")]
    private ?string $email = null;
    

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"NotBlank")]
    private ?string $categorie = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"NotBlank")]
    private ?string $etat_reclamation = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"NotBlank")]
    private ?string $priorite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser($idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail( $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie($categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getEtatReclamation(): ?string
    {
        return $this->etat_reclamation;
    }

    public function setEtatReclamation($etat_reclamation): self
    {
        $this->etat_reclamation = $etat_reclamation;

        return $this;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite($priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }
}
