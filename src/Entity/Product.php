<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     * @Groups("product")
     */
    private ?int $id = null;

    #[ORM\Column(length: 255)]
     /**
     * @Groups("product")
     */
    private ?string $nameProduct = null;

    #[ORM\Column(type: Types::TEXT)]
     /**
     * @Groups("product")
     */
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
     /**
     * @Groups("product")
     */
    private ?string $moreInformations = null;

    #[ORM\Column]
     /**
     * @Groups("product")
     */
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
     /**
     * @Groups("product")
     */
    private ?bool $isBest = null;

    #[ORM\Column(nullable: true)]
     /**
     * @Groups("product")
     */
    private ?bool $isNew = null;

    #[ORM\Column(nullable: true)]
     /**
     * @Groups("product")
     */
    private ?bool $isFeatured = null;

    #[ORM\Column(nullable: true)]
     /**
     * @Groups("product")
     */
    private ?bool $isSpecialOffer = null;

    #[ORM\Column(length: 255)]
     /**
     * @Groups("product")
     */
    private ?string $image = null;

    #[ORM\Column]
     /**
     * @Groups("product")
     */
    private ?int $quantity = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
     /**
     * @Groups("product")
     */
    private ?string $tags = null;

    #[ORM\Column(length: 255, nullable: true)]
     /**
     * @Groups("product")
     */
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
     /**
     * @Groups("product")
     */
    private ?Categories $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ReviewsProduct::class)]
    private Collection $reviewsProducts;

    public function __construct()
    {
        $this->reviewsProducts = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProduct(): ?string
    {
        return $this->nameProduct;
    }

    public function setNameProduct( $nameProduct): self
    {
        $this->nameProduct = $nameProduct;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription( $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMoreInformations(): ?string
    {
        return $this->moreInformations;
    }

    public function setMoreInformations( $moreInformations): self
    {
        $this->moreInformations = $moreInformations;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice( $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isIsBest(): ?bool
    {
        return $this->isBest;
    }

    public function setIsBest( $isBest): self
    {
        $this->isBest = $isBest;

        return $this;
    }

    public function isIsNew(): ?bool
    {
        return $this->isNew;
    }

    public function setIsNew( $isNew): self
    {
        $this->isNew = $isNew;

        return $this;
    }

    public function isIsFeatured(): ?bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured( $isFeatured): self
    {
        $this->isFeatured = $isFeatured;

        return $this;
    }

    public function isIsSpecialOffer(): ?bool
    {
        return $this->isSpecialOffer;
    }

    public function setIsSpecialOffer( $isSpecialOffer): self
    {
        $this->isSpecialOffer = $isSpecialOffer;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage( $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity( $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

   

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags( $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug( $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory( $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ReviewsProduct>
     */
    public function getReviewsProducts(): Collection
    {
        return $this->reviewsProducts;
    }

    public function addReviewsProduct(ReviewsProduct $reviewsProduct): self
    {
        if (!$this->reviewsProducts->contains($reviewsProduct)) {
            $this->reviewsProducts->add($reviewsProduct);
            $reviewsProduct->setProduct($this);
        }

        return $this;
    }

    public function removeReviewsProduct(ReviewsProduct $reviewsProduct): self
    {
        if ($this->reviewsProducts->removeElement($reviewsProduct)) {
            // set the owning side to null (unless already changed)
            if ($reviewsProduct->getProduct() === $this) {
                $reviewsProduct->setProduct(null);
            }
        }

        return $this;
    }
}
