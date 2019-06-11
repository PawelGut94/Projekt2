<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoryOrdersRepository")
 */
class HistoryOrders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="historyOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOrder;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Institution", inversedBy="historyOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $institution;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoryOrdersDetails", mappedBy="numberOrder")
     */
    private $historyOrdersDetails;

    public function __construct()
    {
        $this->historyOrdersDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateOrder(): ?\DateTimeInterface
    {
        return $this->dateOrder;
    }

    public function setDateOrder(\DateTimeInterface $dateOrder): self
    {
        $this->dateOrder = $dateOrder;

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

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): self
    {
        $this->institution = $institution;

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
            $historyOrdersDetail->setNumberOrder($this);
        }

        return $this;
    }

    public function removeHistoryOrdersDetail(HistoryOrdersDetails $historyOrdersDetail): self
    {
        if ($this->historyOrdersDetails->contains($historyOrdersDetail)) {
            $this->historyOrdersDetails->removeElement($historyOrdersDetail);
            // set the owning side to null (unless already changed)
            if ($historyOrdersDetail->getNumberOrder() === $this) {
                $historyOrdersDetail->setNumberOrder(null);
            }
        }

        return $this;
    }
}
