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

    /**
     * @var Collection<int, ArticlesPanier>
     */
    #[ORM\OneToMany(targetEntity: ArticlesPanier::class, mappedBy: 'panier')]
    private Collection $articles;

    #[ORM\OneToOne(mappedBy: 'panier', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ArticlesPanier>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(ArticlesPanier $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setPanier($this);
        }

        return $this;
    }

    public function removeArticle(ArticlesPanier $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getPanier() === $this) {
                $article->setPanier(null);
            }
        }

        return $this;
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
}
