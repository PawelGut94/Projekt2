<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionRepository")
 */
class Institution
{
    const mainInstitution = 'główny';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AvailabilityOffer", mappedBy="institution", orphanRemoval=true)
     */
    private $availabilityOffers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ShoppingCart", mappedBy="institution")
     */
    private $shoppingCart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderDetails", mappedBy="institution")
     */
    private $orderDetails;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderCart", mappedBy="institution")
     */
    private $orderCart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoryOrders", mappedBy="institution")
     */
    private $historyOrders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InstitutionPhone", mappedBy="institution", cascade={"persist"}, orphanRemoval=true)
     */
    private $institutionPhones;


    public function __construct()
    {
        $this->availabilityOffers = new ArrayCollection();
        $this->shoppingCart = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
        $this->orderCart = new ArrayCollection();
        $this->historyOrders = new ArrayCollection();
        $this->institutionPhones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
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
     * @return Collection|AvailabilityOffer[]
     */
    public function getAvailabilityOffers(): Collection
    {
        return $this->availabilityOffers;
    }

    public function addAvailabilityOffer(AvailabilityOffer $availabilityOffer): self
    {
        if (!$this->availabilityOffers->contains($availabilityOffer)) {
            $this->availabilityOffers[] = $availabilityOffer;
            $availabilityOffer->setInstitution($this);
        }

        return $this;
    }

    public function removeAvailabilityOffer(AvailabilityOffer $availabilityOffer): self
    {
        if ($this->availabilityOffers->contains($availabilityOffer)) {
            $this->availabilityOffers->removeElement($availabilityOffer);
            // set the owning side to null (unless already changed)
            if ($availabilityOffer->getInstitution() === $this) {
                $availabilityOffer->setInstitution(null);
            }
        }

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
            $shoppingCart->setInstitution($this);
        }

        return $this;
    }

    public function removeShoppingCart(ShoppingCart $shoppingCart): self
    {
        if ($this->shoppingCart->contains($shoppingCart)) {
            $this->shoppingCart->removeElement($shoppingCart);
            // set the owning side to null (unless already changed)
            if ($shoppingCart->getInstitution() === $this) {
                $shoppingCart->setInstitution(null);
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
            $orderDetail->setInstitution($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->removeElement($orderDetail);
            // set the owning side to null (unless already changed)
            if ($orderDetail->getInstitution() === $this) {
                $orderDetail->setInstitution(null);
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
            $orderCart->setInstitution($this);
        }

        return $this;
    }

    public function removeOrderCart(OrderCart $orderCart): self
    {
        if ($this->orderCart->contains($orderCart)) {
            $this->orderCart->removeElement($orderCart);
            // set the owning side to null (unless already changed)
            if ($orderCart->getInstitution() === $this) {
                $orderCart->setInstitution(null);
            }
        }

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
            $historyOrder->setInstitution($this);
        }

        return $this;
    }

    public function removeHistoryOrder(HistoryOrders $historyOrder): self
    {
        if ($this->historyOrders->contains($historyOrder)) {
            $this->historyOrders->removeElement($historyOrder);
            // set the owning side to null (unless already changed)
            if ($historyOrder->getInstitution() === $this) {
                $historyOrder->setInstitution(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InstitutionPhone[]
     */
    public function getInstitutionPhones(): Collection
    {
        return $this->institutionPhones;
    }

    public function addInstitutionPhone(InstitutionPhone $institutionPhone): self
    {
        if (!$this->institutionPhones->contains($institutionPhone)) {
            $this->institutionPhones[] = $institutionPhone;
            $institutionPhone->setInstitution($this);
        }

        return $this;
    }

    public function removeInstitutionPhone(InstitutionPhone $institutionPhone): self
    {
        if ($this->institutionPhones->contains($institutionPhone)) {
            $this->institutionPhones->removeElement($institutionPhone);
            // set the owning side to null (unless already changed)
            if ($institutionPhone->getInstitution() === $this) {
                $institutionPhone->setInstitution(null);
            }
        }

        return $this;
    }

}
