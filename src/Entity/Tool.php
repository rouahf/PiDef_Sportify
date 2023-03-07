<?php

namespace App\Entity;

use App\Repository\ToolRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ToolRepository::class)]
class Tool
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "nom requis") ]
    #[Assert\Type(type: ['string'],message:"The name entered: '{{ value }}' should be of type {{ type }}")]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $returned = null;

    #[ORM\ManyToOne(inversedBy: 'tools')]
    private ?Event $evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isReturned(): ?bool
    {
        return $this->returned;
    }

    public function setReturned(bool $returned): self
    {
        $this->returned = $returned;

        return $this;
    }

    public function getEvenement(): ?Event
    {
        return $this->evenement;
    }

    public function setEvenement(?Event $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }
}
