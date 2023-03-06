<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\Collection;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[Assert\NotBlank(message:"NotBlank")]
class Type
{
    #[ORM\Id]
    #[Assert\NotBlank(message:"NotBlank")]
    #[ORM\GeneratedValue]
    #[Assert\NotBlank(message:"NotBlank")]
    #[ORM\Column]
    #[Assert\NotBlank(message:"NotBlank")]
        /**
     * @Groups("priorite")
     */
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"NotBlank")]
    
        /**
     * @Groups("priorite")
     */
    private ?string $nom_type = null;

    #[ORM\OneToMany(mappedBy: 'id_type', targetEntity: Priorite::class)]
    #[Assert\NotBlank(message:"NotBlank")]
    private Collection $priorites;

    public function __construct()
    {
        $this->priorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomType(): ?string
    {
        return $this->nom_type;
    }

    public function setNomType(string $nom_type): self
    {
        $this->nom_type = $nom_type;

        return $this;
    }

    /**
     * @return Collection<int, Priorite>
     */
    public function getPriorites(): Collection
    {
        return $this->priorites;
    }

    public function addPriorite(Priorite $priorite): self
    {
        if (!$this->priorites->contains($priorite)) {
            $this->priorites->add($priorite);
            $priorite->setIdType($this);
        }

        return $this;
    }

    public function removePriorite(Priorite $priorite): self
    {
        if ($this->priorites->removeElement($priorite)) {
            // set the owning side to null (unless already changed)
            if ($priorite->getIdType() === $this) {
                $priorite->setIdType(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
       return $this->nom_type;

    }
}
