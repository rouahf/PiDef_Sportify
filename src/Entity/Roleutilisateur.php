<?php

namespace App\Entity;

use App\Repository\RoleutilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleutilisateurRepository::class)]
class Roleutilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $roleut = null;

    #[ORM\OneToMany(mappedBy: 'roleutilisateur', targetEntity: Utilisateur::class)]
    private Collection $typeut;

    public function __construct()
    {
        $this->typeut = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleut(): ?string
    {
        return $this->roleut;
    }

    public function setRoleut(string $roleut): self
    {
        $this->roleut = $roleut;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getTypeut(): Collection
    {
        return $this->typeut;
    }

    public function addTypeut(Utilisateur $typeut): self
    {
        if (!$this->typeut->contains($typeut)) {
            $this->typeut->add($typeut);
            $typeut->setRoleutilisateur($this);
        }

        return $this;
    }

    public function removeTypeut(Utilisateur $typeut): self
    {
        if ($this->typeut->removeElement($typeut)) {
            // set the owning side to null (unless already changed)
            if ($typeut->getRoleutilisateur() === $this) {
                $typeut->setRoleutilisateur(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->roleut;
    }
}
