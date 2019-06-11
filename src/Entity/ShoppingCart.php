<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingCartRepository")
 */
class ShoppingCart
{
    const add = 'dodaj';
    const delete = 'usun';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="shoppingCart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shoppingCart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $individualOrder;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;


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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getIndividualOrder(): ?bool
    {
        return $this->individualOrder;
    }

    public function setIndividualOrder(bool $individualOrder): self
    {
        $this->individualOrder = $individualOrder;

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
}
