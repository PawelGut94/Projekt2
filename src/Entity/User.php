<?php
// src/AppBundle/Entity/user.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nip;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ShoppingCart", mappedBy="user", orphanRemoval=true)
     */
    private $shoppingCart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderCart", mappedBy="user")
     */
    private $orderCart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderDetails", mappedBy="user", orphanRemoval=true)
     */
    private $orderDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $clientNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoryOrders", mappedBy="user")
     */
    private $historyOrders;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rodo;


    public function __construct()
    {
        parent::__construct();
        $this->shoppingCart = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->orderCart = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
        $this->historyOrders = new ArrayCollection();
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getNip(): ?int
    {
        return $this->nip;
    }

    public function setNip(int $nip): self
    {
        $this->nip = $nip;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|ShoppingCart[]
     */
    public function getShoppingCart(): Collection
    {
        return $this->shoppingCart;
    }

    public function addShoppingCart(ShoppingCart $shoppingCart): self
    {
        if (!$this->shoppingCart->contains($shoppingCart)) {
            $this->shoppingCart[] = $shoppingCart;
            $shoppingCart->setUser($this);
        }

        return $this;
    }

    public function removeShoppingCart(ShoppingCart $shoppingCart): self
    {
        if ($this->shoppingCart->contains($shoppingCart)) {
            $this->shoppingCart->removeElement($shoppingCart);
            // set the owning side to null (unless already changed)
            if ($shoppingCart->getUser() === $this) {
                $shoppingCart->setUser(null);
            }
        }

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
            $orderCart->setUser($this);
        }

        return $this;
    }

    public function removeOrderCart(OrderCart $orderCart): self
    {
        if ($this->orderCart->contains($orderCart)) {
            $this->orderCart->removeElement($orderCart);
            // set the owning side to null (unless already changed)
            if ($orderCart->getUser() === $this) {
                $orderCart->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OrderDetails[]
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setUser($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->removeElement($orderDetail);
            // set the owning side to null (unless already changed)
            if ($orderDetail->getUser() === $this) {
                $orderDetail->setUser(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getClientNumber(): ?int
    {
        return $this->clientNumber;
    }

    public function setClientNumber(?int $clientNumber): self
    {
        $this->clientNumber = $clientNumber;

        return $this;
    }

    /**
     * @return Collection|HistoryOrders[]
     */
    public function getHistoryOrders(): Collection
    {
        return $this->historyOrders;
    }

    public function addHistoryOrder(HistoryOrders $historyOrder): self
    {
        if (!$this->historyOrders->contains($historyOrder)) {
            $this->historyOrders[] = $historyOrder;
            $historyOrder->setUser($this);
        }

        return $this;
    }

    public function removeHistoryOrder(HistoryOrders $historyOrder): self
    {
        if ($this->historyOrders->contains($historyOrder)) {
            $this->historyOrders->removeElement($historyOrder);
            // set the owning side to null (unless already changed)
            if ($historyOrder->getUser() === $this) {
                $historyOrder->setUser(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRodo(): ?bool
    {
        return $this->rodo;
    }

    public function setRodo(?bool $rodo): self
    {
        $this->rodo = $rodo;

        return $this;
    }
    
}