<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubcategoriesRepository")
 */
class Subcategories
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="subcategories")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="subcategory")
     */
    private $offer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SearchOffer", mappedBy="subcategory")
     */
    private $searchOffer;

    public function __construct()
    {
        $this->offer = new ArrayCollection();
        $this->searchOffer = new ArrayCollection();
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


    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

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
            $offer->setSubcategory($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offer->contains($offer)) {
            $this->offer->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getSubcategory() === $this) {
                $offer->setSubcategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SearchOffer[]
     */
    public function getSearchOffer(): Collection
    {
        return $this->searchOffer;
    }

    public function addSearchOffer(SearchOffer $searchOffer): self
    {
        if (!$this->searchOffer->contains($searchOffer)) {
            $this->searchOffer[] = $searchOffer;
            $searchOffer->setSubcategory($this);
        }

        return $this;
    }

    public function removeSearchOffer(SearchOffer $searchOffer): self
    {
        if ($this->searchOffer->contains($searchOffer)) {
            $this->searchOffer->removeElement($searchOffer);
            // set the owning side to null (unless already changed)
            if ($searchOffer->getSubcategory() === $this) {
                $searchOffer->setSubcategory(null);
            }
        }

        return $this;
    }

}
