<?php

namespace App\Entity;

use App\Repository\CartDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartDetailsRepository::class)]
class CartDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $productName = null;

    #[ORM\Column]
    private ?float $productPrice = null;

    #[ORM\Column]
    private ?int $productQuantity = null;

    #[ORM\Column]
    private ?float $subtotalHt = null;

    #[ORM\Column]
    private ?float $taxe = null;

    #[ORM\Column]
    private ?float $subTotalTtc = null;

    #[ORM\ManyToOne(inversedBy: 'cartDetails')]
    private ?Cart $Carts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getProductQuantity(): ?int
    {
        return $this->productQuantity;
    }

    public function setProductQuantity(int $productQuantity): self
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    public function getSubtotalHt(): ?float
    {
        return $this->subtotalHt;
    }

    public function setSubtotalHt(float $subtotalHt): self
    {
        $this->subtotalHt = $subtotalHt;

        return $this;
    }

    public function getTaxe(): ?float
    {
        return $this->taxe;
    }

    public function setTaxe(float $taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getSubTotalTtc(): ?float
    {
        return $this->subTotalTtc;
    }

    public function setSubTotalTtc(float $subTotalTtc): self
    {
        $this->subTotalTtc = $subTotalTtc;

        return $this;
    }

    public function getCarts(): ?Cart
    {
        return $this->Carts;
    }

    public function setCarts(?Cart $Carts): self
    {
        $this->Carts = $Carts;

        return $this;
    }
}