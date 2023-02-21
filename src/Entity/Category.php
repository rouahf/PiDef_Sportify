<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\NotBlank(message:"NotBlank")]

    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:"NotBlank")]
    #[Assert\Type(type: ['alpha'],message:"The field '{{ value }}' is not valid")]
    private ?string $cat_title = null;

    #[ORM\OneToMany(mappedBy: 'cat', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatTitle(): ?string
    {
        return $this->cat_title;
    }

    public function setCatTitle(string $cat_title): self
    {
        $this->cat_title = $cat_title;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCat($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCat() === $this) {
                $product->setCat(null);
            }
        }

        return $this;
    }
}
