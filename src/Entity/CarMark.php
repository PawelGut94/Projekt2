<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarMarkRepository")
 */
class CarMark
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
     * @ORM\OneToMany(targetEntity="App\Entity\CarModel", mappedBy="mark")
     */
    private $carModel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OfferCarMark", mappedBy="carMark")
     */
    private $offerCarMark;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SearchOffer", mappedBy="mark")
     */
    private $searchOffers;

    public function __construct()
    {
        $this->carModel = new ArrayCollection();
        $this->offerCarMark = new ArrayCollection();
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
     * @return Collection|CarModel[]
     */
    public function getCarModel(): Collection
    {
        return $this->carModel;
    }

    public function addCarModel(CarModel $carModel): self
    {
        if (!$this->carModel->contains($carModel)) {
            $this->carModel[] = $carModel;
            $carModel->setMark($this);
        }

        return $this;
    }

    public function removeCarModel(CarModel $carModel): self
    {
        if ($this->carModel->contains($carModel)) {
            $this->carModel->removeElement($carModel);
            // set the owning side to null (unless already changed)
            if ($carModel->getMark() === $this) {
                $carModel->setMark(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OfferCarMark[]
     */
    public function getOfferCarMark(): Collection
    {
        return $this->offerCarMark;
    }

    public function addOfferCarMark(OfferCarMark $offerCarMark): self
    {
        if (!$this->offerCarMark->contains($offerCarMark)) {
            $this->offerCarMark[] = $offerCarMark;
            $offerCarMark->setCarMark($this);
        }

        return $this;
    }

    public function removeOfferCarMark(OfferCarMark $offerCarMark): self
    {
        if ($this->offerCarMark->contains($offerCarMark)) {
            $this->offerCarMark->removeElement($offerCarMark);
            // set the owning side to null (unless already changed)
            if ($offerCarMark->getCarMark() === $this) {
                $offerCarMark->setCarMark(null);
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
            $searchOffer->setMark($this);
        }

        return $this;
    }

    public function removeSearchOffer(SearchOffer $searchOffer): self
    {
        if ($this->searchOffers->contains($searchOffer)) {
            $this->searchOffers->removeElement($searchOffer);
            // set the owning side to null (unless already changed)
            if ($searchOffer->getMark() === $this) {
                $searchOffer->setMark(null);
            }
        }

        return $this;
    }
}
