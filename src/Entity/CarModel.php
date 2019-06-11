<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarModelRepository")
 */
class CarModel
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
     * @ORM\ManyToOne(targetEntity="App\Entity\CarMark", inversedBy="carModel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mark;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OfferCarModel", mappedBy="carModel")
     */
    private $offerCarModel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SearchOffer", mappedBy="model")
     */
    private $searchOffers;

    public function __construct()
    {
        $this->offerCarModel = new ArrayCollection();
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

    public function getMark(): ?CarMark
    {
        return $this->mark;
    }

    public function setMark(?CarMark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * @return Collection|OfferCarModel[]
     */
    public function getOfferCarModel(): Collection
    {
        return $this->offerCarModel;
    }

    public function addOfferCarModel(OfferCarModel $offerCarModel): self
    {
        if (!$this->offerCarModel->contains($offerCarModel)) {
            $this->offerCarModel[] = $offerCarModel;
            $offerCarModel->setCarModel($this);
        }

        return $this;
    }

    public function removeOfferCarModel(OfferCarModel $offerCarModel): self
    {
        if ($this->offerCarModel->contains($offerCarModel)) {
            $this->offerCarModel->removeElement($offerCarModel);
            // set the owning side to null (unless already changed)
            if ($offerCarModel->getCarModel() === $this) {
                $offerCarModel->setCarModel(null);
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
            $searchOffer->setModel($this);
        }

        return $this;
    }

    public function removeSearchOffer(SearchOffer $searchOffer): self
    {
        if ($this->searchOffers->contains($searchOffer)) {
            $this->searchOffers->removeElement($searchOffer);
            // set the owning side to null (unless already changed)
            if ($searchOffer->getModel() === $this) {
                $searchOffer->setModel(null);
            }
        }

        return $this;
    }
}
