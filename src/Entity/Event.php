<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
     #[Groups(['event'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "nom requis") ]
    #[Assert\Length(min:4, minMessage:"minimum of 4 letters pls")]
    #[Groups(['event'])]

    private ?string $nom = null;

    #[ORM\Column(length: 255)]
      #[Groups(['event'])]
    private ?string $type = null;
    #[ORM\OneToMany(mappedBy: 'evenement', targetEntity: Tool::class , cascade:["remove"])]
     #[Groups(['event'])]
    private Collection $tools;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
   #[Groups(['event'])]
    private ?\DateTimeInterface $dateEvent = null;

    public function __construct()
    {
        $this->tools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Tool>
     */
    public function getTools(): Collection
    {
        return $this->tools;
    }

    public function addTool(Tool $tool): self
    {
        if (!$this->tools->contains($tool)) {
            $this->tools->add($tool);
            $tool->setEvenement($this);
        }

        return $this;
    }

    public function removeTool(Tool $tool): self
    {
        if ($this->tools->removeElement($tool)) {
            // set the owning side to null (unless already changed)
            if ($tool->getEvenement() === $this) {
                $tool->setEvenement(null);
            }
        }

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }
}
