<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="brand", orphanRemoval=true)
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity=ShippingFees::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $shippingFees;

    /**
     * @ORM\OneToMany(targetEntity=VAT::class, mappedBy="brand", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $VAT;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->VAT = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setBrand($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBrand() === $this) {
                $product->setBrand(null);
            }
        }

        return $this;
    }

    public function getShippingFees(): ShippingFees
    {
        return $this->shippingFees;
    }

    public function setShippingFees(ShippingFees $shippingFees): self
    {
        $this->shippingFees = $shippingFees;

        return $this;
    }

    /**
     * @return Collection|VAT[]
     */
    public function getVAT(): Collection
    {
        return $this->VAT;
    }

    public function addVAT(VAT $vAT): self
    {
        if (!$this->VAT->contains($vAT)) {
            $this->VAT[] = $vAT;
            $vAT->setBrand($this);
        }

        return $this;
    }

    public function removeVAT(VAT $vAT): self
    {
        if ($this->VAT->removeElement($vAT)) {
            // set the owning side to null (unless already changed)
            if ($vAT->getBrand() === $this) {
                $vAT->setBrand(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
