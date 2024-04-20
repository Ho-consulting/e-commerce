<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    private ?int $stockQuantite = null;

    /**
     * @var Collection<int, ArticlesPanier>
     */
    #[ORM\OneToMany(targetEntity: ArticlesPanier::class, mappedBy: 'produit')]
    private Collection $articlesPaniers;

    public function __construct()
    {
        $this->articlesPaniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
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

    /**
     * @return Collection<int, ArticlesPanier>
     */
    public function getArticlesPaniers(): Collection
    {
        return $this->articlesPaniers;
    }

    public function addArticlesPanier(ArticlesPanier $articlesPanier): static
    {
        if (!$this->articlesPaniers->contains($articlesPanier)) {
            $this->articlesPaniers->add($articlesPanier);
            $articlesPanier->setProduit($this);
        }

        return $this;
    }

    public function removeArticlesPanier(ArticlesPanier $articlesPanier): static
    {
        if ($this->articlesPaniers->removeElement($articlesPanier)) {
            // set the owning side to null (unless already changed)
            if ($articlesPanier->getProduit() === $this) {
                $articlesPanier->setProduit(null);
            }
        }

        return $this;
    }
}
