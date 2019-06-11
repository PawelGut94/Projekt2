<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
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
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="offer")
     * @ORM\JoinColumn(name="id_category", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subcategories", inversedBy="offer")
     * @Assert\NotBlank()
     */
    private $subcategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AvailabilityOffer", mappedBy="offer", cascade={"persist"})
     */
    private $availabilityOffer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ShoppingCart", mappedBy="offer", orphanRemoval=true)
     */
    private $shoppingCart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OfferCarModel", mappedBy="offer", cascade={"persist"}, orphanRemoval=true)
     */
    private $offerCarModel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OfferCarMark", mappedBy="offer", cascade={"persist"}, orphanRemoval=true)
     */
    private $offerCarMark;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderDetails", mappedBy="offer")
     */
    private $orderDetails;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoryOrdersDetails", mappedBy="offer")
     */
    private $historyOrdersDetails;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OfferPhotos", mappedBy="offer", cascade={"persist"}, orphanRemoval=true)
     */
    private $offerPhotos;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;



    public function __construct()
    {
        $this->availabilityOffer = new ArrayCollection();
        $this->shoppingCart = new ArrayCollection();
        $this->offerCarModel = new ArrayCollection();
        $this->offerCarMark = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
        $this->historyOrdersDetails = new ArrayCollection();
        $this->offerPhotos = new ArrayCollection();
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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubcategory(): ?Subcategories
    {
        return $this->subcategory;
    }

    public function setSubcategory(?Subcategories $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * @return Collection|AvailabilityOffer[]
     */
    public function getAvailabilityOffer(): Collection
    {
        return $this->availabilityOffer;
    }

    public function addAvailabilityOffer(AvailabilityOffer $availabilityOffer): self
    {
        if (!$this->availabilityOffer->contains($availabilityOffer)) {
            $this->availabilityOffer[] = $availabilityOffer;
            $availabilityOffer->setOffer($this);
        }

        return $this;
    }

    public function removeAvailabilityOffer(AvailabilityOffer $availabilityOffer): self
    {
        if ($this->availabilityOffer->contains($availabilityOffer)) {
            $this->availabilityOffer->removeElement($availabilityOffer);
            // set the owning side to null (unless already changed)
            if ($availabilityOffer->getOffer() === $this) {
                $availabilityOffer->setOffer(null);
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
            $shoppingCart->setOffer($this);
        }

        return $this;
    }

    public function removeShoppingCart(ShoppingCart $shoppingCart): self
    {
        if ($this->shoppingCart->contains($shoppingCart)) {
            $this->shoppingCart->removeElement($shoppingCart);
            // set the owning side to null (unless already changed)
            if ($shoppingCart->getOffer() === $this) {
                $shoppingCart->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OfferCarModel[]
     */
    public function getOfferCarModel(): Collection
    {
        return $this->offerCarModel;
    }

    public function addOfferCarModel(OfferCarModel $offerCarModel): self
    {
        if (!$this->offerCarModel->contains($offerCarModel)) {
            $this->offerCarModel[] = $offerCarModel;
            $offerCarModel->setOffer($this);
        }

        return $this;
    }

    public function removeOfferCarModel(OfferCarModel $offerCarModel): self
    {
        if ($this->offerCarModel->contains($offerCarModel)) {
            $this->offerCarModel->removeElement($offerCarModel);
            // set the owning side to null (unless already changed)
            if ($offerCarModel->getOffer() === $this) {
                $offerCarModel->setOffer(null);
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
            $offerCarMark->setOffer($this);
        }

        return $this;
    }

    public function removeOfferCarMark(OfferCarMark $offerCarMark): self
    {
        if ($this->offerCarMark->contains($offerCarMark)) {
            $this->offerCarMark->removeElement($offerCarMark);
            // set the owning side to null (unless already changed)
            if ($offerCarMark->getOffer() === $this) {
                $offerCarMark->setOffer(null);
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
            $orderDetail->setOffer($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->removeElement($orderDetail);
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOffer() === $this) {
                $orderDetail->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HistoryOrdersDetails[]
     */
    public function getHistoryOrdersDetails(): Collection
    {
        return $this->historyOrdersDetails;
    }

    public function addHistoryOrdersDetail(HistoryOrdersDetails $historyOrdersDetail): self
    {
        if (!$this->historyOrdersDetails->contains($historyOrdersDetail)) {
            $this->historyOrdersDetails[] = $historyOrdersDetail;
            $historyOrdersDetail->setOffer($this);
        }

        return $this;
    }

    public function removeHistoryOrdersDetail(HistoryOrdersDetails $historyOrdersDetail): self
    {
        if ($this->historyOrdersDetails->contains($historyOrdersDetail)) {
            $this->historyOrdersDetails->removeElement($historyOrdersDetail);
            // set the owning side to null (unless already changed)
            if ($historyOrdersDetail->getOffer() === $this) {
                $historyOrdersDetail->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OfferPhotos[]
     */
    public function getOfferPhotos(): Collection
    {
        return $this->offerPhotos;
    }

    public function addOfferPhoto(OfferPhotos $offerPhoto): self
    {
        if (!$this->offerPhotos->contains($offerPhoto)) {
            $this->offerPhotos[] = $offerPhoto;
            $offerPhoto->setOffer($this);
        }

        return $this;
    }

    public function removeOfferPhoto(OfferPhotos $offerPhoto): self
    {
        if ($this->offerPhotos->contains($offerPhoto)) {
            $this->offerPhotos->removeElement($offerPhoto);
            // set the owning side to null (unless already changed)
            if ($offerPhoto->getOffer() === $this) {
                $offerPhoto->setOffer(null);
            }
        }

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
