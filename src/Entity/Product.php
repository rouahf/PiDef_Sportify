<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\NotBlank(message:"NotBlank")]

    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:"NotBlank")]
    #[Assert\Type(type: ['alpha'],message:"The field '{{ value }}' is not valid")]
    private ?string $name_produits = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"NotBlank")]
    #[Assert\Type(type: ['alpha'],message:"The field '{{ value }}' is not valid")]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"NotBlank")]

    private ?int $quati_stock = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"NotBlank")]

    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $cat = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"NotBlank")]

    private ?string $image ;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Panier::class)]
    private Collection $paniers;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProduits(): ?string
    {
        return $this->name_produits;
    }

    public function setNameProduits(string $name_produits): self
    {
        $this->name_produits = $name_produits;

        return $this;
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

    public function getQuatiStock(): ?int
    {
        return $this->quati_stock;
    }

    public function setQuatiStock(int $quati_stock): self
    {
        $this->quati_stock = $quati_stock;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCat(): ?Category
    {
        return $this->cat;
    }

    public function setCat(?Category $cat): self
    {
        $this->cat = $cat;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setProduit($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getProduit() === $this) {
                $panier->setProduit(null);
            }
        }

        return $this;
    }
}
