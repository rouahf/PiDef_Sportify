<?php

namespace App\Entity;

use App\Repository\PrioriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrioriteRepository::class)]
#[Assert\NotBlank(message:"NotBlank")]
class Priorite
{
    #[ORM\Id]
    #[Assert\NotBlank(message:"NotBlank")]
    #[ORM\GeneratedValue]
    #[Assert\NotBlank(message:"NotBlank")]
    #[ORM\Column]
    #[Assert\NotBlank(message:"NotBlank")]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"NotBlank")]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'priorites')]
    #[Assert\NotBlank(message:"NotBlank")]
    private ?Type $id_type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdType(): ?Type
    {
        return $this->id_type;
    }

    public function setIdType(?Type $id_type): self
    {
        $this->id_type = $id_type;

        return $this;
    }
    public function __toString():string 
    {
       return $this->description;

    }
}
