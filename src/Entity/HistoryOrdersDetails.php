<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoryOrdersDetailsRepository")
 */
class HistoryOrdersDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\HistoryOrders", inversedBy="historyOrdersDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $numberOrder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="historyOrdersDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offer;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $total_price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOrder(): ?HistoryOrders
    {
        return $this->numberOrder;
    }

    public function setNumberOrder(?HistoryOrders $numberOrder): self
    {
        $this->numberOrder = $numberOrder;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTotalPrice()
    {
        return $this->total_price;
    }

    public function setTotalPrice($total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }
}
