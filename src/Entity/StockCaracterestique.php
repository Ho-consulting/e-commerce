<?php

namespace App\Entity;

use App\Repository\StockCaracterestiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockCaracterestiqueRepository::class)]
class StockCaracterestique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $stockQuantite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $caracterestique = null;

    #[ORM\OneToOne(inversedBy: 'stockCaracterestique', cascade: ['persist', 'remove'])]
    private ?Produit $produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockQuantite(): ?int
    {
        return $this->stockQuantite;
    }

    public function setStockQuantite(?int $stockQuantite): static
    {
        $this->stockQuantite = $stockQuantite;

        return $this;
    }

    public function getCaracterestique(): ?string
    {
        return $this->caracterestique;
    }

    public function setCaracterestique(?string $caracterestique): static
    {
        $this->caracterestique = $caracterestique;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }
}
