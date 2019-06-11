<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvailabilityOfferRepository")
 */
class AvailabilityOffer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="availabilityOffer")
     * @ORM\JoinColumn(nullable=false, name="id_offer", referencedColumnName="id", onDelete="CASCADE")
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Institution", inversedBy="availabilityOffers")
     * @ORM\JoinColumn(name="id_institution", referencedColumnName="id")
     */
    private $institution;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;


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

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): self
    {
        $this->institution = $institution;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }


   
}
