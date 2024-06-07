<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'panier', cascade: ['persist'])]
    private ?User $user = null;

    /**
     * @var Collection<int, ArticlesPanier>
     */
    #[ORM\OneToMany(targetEntity: ArticlesPanier::class, mappedBy: 'panier')]
    private Collection $articlesPanier;

    #[ORM\Column(nullable: true)]
    private ?float $prixTotal = null;

    #[ORM\Column(nullable: true)]
    private ?float $delivry = null;

    public function __construct()
    {
        $this->articlesPanier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setPanier(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPanier() !== $this) {
            $user->setPanier($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ArticlesPanier>
     */
    public function getArticlesPanier(): Collection
    {
        return $this->articlesPanier;
    }

    public function addArticlesPanier(ArticlesPanier $articlesPanier): static
    {
        if (!$this->articlesPanier->contains($articlesPanier)) {
            $this->articlesPanier->add($articlesPanier);
            $articlesPanier->setPanier($this);
        }

        return $this;
    }

    public function removeArticlesPanier(ArticlesPanier $articlesPanier): static
    {
        if ($this->articlesPanier->removeElement($articlesPanier)) {
            // set the owning side to null (unless already changed)
            if ($articlesPanier->getPanier() === $this) {
                $articlesPanier->setPanier(null);
            }
        }

        return $this;
    }


    public function getTotalPanier(): ?float
    {
        $total = 0;
        foreach ($this->articlesPanier as &$article) {
            $total = $total + $article->getTotal();
        }
        return $total;
    }


    public function getDelivryMax(): ?float
    {
        if ($this->getArticlesPanier()[0] == null) {
            return 0;
        }
        $max = $this->getArticlesPanier()[0]->getDelivry();
        foreach ($this->getArticlesPanier() as &$article) {
            if ($max < $article->getDelivry()) {
                $max = $article->getDelivry();
            }
            
        }
        return $max;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(?float $prixTotal): static
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getDelivry(): ?float
    {
        return $this->delivry;
    }

    public function setDelivry(?float $delivry): static
    {
        $this->delivry = $delivry;

        return $this;
    }

    

}
