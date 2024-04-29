<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
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

    #[ORM\Column(nullable: true)]
    private ?bool $availible = null;


    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'products_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

       /* if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
        */
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }


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

    public function isAvailible(): ?bool
    {
        return $this->availible;
    }

    public function setAvailible(?bool $availible): static
    {
        $this->availible = $availible;

        return $this;
    }

}
