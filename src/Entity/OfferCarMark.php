<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferCarMarkRepository")
 */
class OfferCarMark
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarMark", inversedBy="offerCarMark")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carMark;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="offerCarMark")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offer;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarMark(): ?CarMark
    {
        return $this->carMark;
    }

    public function setCarMark(?CarMark $carMark): self
    {
        $this->carMark = $carMark;

        return $this;
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

}
