<?php

namespace App\Entity;

use App\Repository\SearchDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SearchDataRepository::class)]
class SearchData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   /**
     * @var CategorieA[]
     */
    private $categories = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories(?array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
