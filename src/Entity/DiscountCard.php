<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiscountCardRepository")
 */
class DiscountCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $clientNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $discount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientNumber(): ?int
    {
        return $this->clientNumber;
    }

    public function setClientNumber(int $clientNumber): self
    {
        $this->clientNumber = $clientNumber;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}
