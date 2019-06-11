<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderStatusRepository")
 */
class OrderStatus
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
     * @ORM\OneToMany(targetEntity="App\Entity\OrderCart", mappedBy="status")
     */
    private $orderCart;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberStatus;

    public function __construct()
    {
        $this->orderCart = new ArrayCollection();
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
     * @return Collection|OrderCart[]
     */
    public function getOrderCart(): Collection
    {
        return $this->orderCart;
    }

    public function addOrderCart(OrderCart $orderCart): self
    {
        if (!$this->orderCart->contains($orderCart)) {
            $this->orderCart[] = $orderCart;
            $orderCart->setStatus($this);
        }

        return $this;
    }

    public function removeOrderCart(OrderCart $orderCart): self
    {
        if ($this->orderCart->contains($orderCart)) {
            $this->orderCart->removeElement($orderCart);
            // set the owning side to null (unless already changed)
            if ($orderCart->getStatus() === $this) {
                $orderCart->setStatus(null);
            }
        }

        return $this;
    }

    public function getNumberStatus(): ?int
    {
        return $this->numberStatus;
    }

    public function setNumberStatus(int $numberStatus): self
    {
        $this->numberStatus = $numberStatus;

        return $this;
    }
    
}
