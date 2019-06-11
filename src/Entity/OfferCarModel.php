<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferCarModelRepository")
 */
class OfferCarModel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="offerCarModel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarModel", inversedBy="offerCarModel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carModel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function getCarModel(): ?CarModel
    {
        return $this->carModel;
    }

    public function setCarModel(?CarModel $carModel): self
    {
        $this->carModel = $carModel;

        return $this;
    }
}
