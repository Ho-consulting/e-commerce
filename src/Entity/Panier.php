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


    #[ORM\OneToOne(mappedBy: 'panier', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @var Collection<int, ArticlesPanier>
     */
    #[ORM\OneToMany(targetEntity: ArticlesPanier::class, mappedBy: 'panier')]
    private Collection $articlesPanier;

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

    
}
