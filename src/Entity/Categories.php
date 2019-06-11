<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subcategories", mappedBy="category")
     */
    private $subcategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="category")
     */
    private $offer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SearchOffer", mappedBy="category")
     */
    private $searchOffers;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
        $this->offer = new ArrayCollection();
        $this->searchOffers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Subcategories[]
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(Subcategories $subcategory): self
    {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories[] = $subcategory;
            $subcategory->setCategorie($this);
        }

        return $this;
    }

    public function removeSubcategory(Subcategories $subcategory): self
    {
        if ($this->subcategories->contains($subcategory)) {
            $this->subcategories->removeElement($subcategory);
            // set the owning side to null (unless already changed)
            if ($subcategory->getCategorie() === $this) {
                $subcategory->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffer(): Collection
    {
        return $this->offer;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offer->contains($offer)) {
            $this->offer[] = $offer;
            $offer->setCategory($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offer->contains($offer)) {
            $this->offer->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getCategory() === $this) {
                $offer->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SearchOffer[]
     */
    public function getSearchOffers(): Collection
    {
        return $this->searchOffers;
    }

    public function addSearchOffer(SearchOffer $searchOffer): self
    {
        if (!$this->searchOffers->contains($searchOffer)) {
            $this->searchOffers[] = $searchOffer;
            $searchOffer->setCategory($this);
        }

        return $this;
    }

    public function removeSearchOffer(SearchOffer $searchOffer): self
    {
        if ($this->searchOffers->contains($searchOffer)) {
            $this->searchOffers->removeElement($searchOffer);
            // set the owning side to null (unless already changed)
            if ($searchOffer->getCategory() === $this) {
                $searchOffer->setCategory(null);
            }
        }

        return $this;
    }

}
