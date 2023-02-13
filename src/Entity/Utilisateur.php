<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "Name is required") ]
    private ?string $nomut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "prenom is required") ]
    private ?string $prenomut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "email is required") ]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $emailut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "mdp is required") ]
    private ?string $mdput = null;

   

    #[ORM\ManyToOne(inversedBy: 'typeut')]
    private ?Roleutilisateur $roleutilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomut(): ?string
    {
        return $this->nomut;
    }

    public function setNomut(string $nomut): self
    {
        $this->nomut = $nomut;

        return $this;
    }

    public function getPrenomut(): ?string
    {
        return $this->prenomut;
    }

    public function setPrenomut(string $prenomut): self
    {
        $this->prenomut = $prenomut;

        return $this;
    }

    public function getEmailut(): ?string
    {
        return $this->emailut;
    }

    public function setEmailut(string $emailut): self
    {
        $this->emailut = $emailut;

        return $this;
    }

    public function getMdput(): ?string
    {
        return $this->mdput;
    }

    public function setMdput(string $mdput): self
    {
        $this->mdput = $mdput;

        return $this;
    }

 

    public function getRoleutilisateur(): ?Roleutilisateur
    {
        return $this->roleutilisateur;
    }

    public function setRoleutilisateur(?Roleutilisateur $roleutilisateur): self
    {
        $this->roleutilisateur = $roleutilisateur;

        return $this;
    }

}
