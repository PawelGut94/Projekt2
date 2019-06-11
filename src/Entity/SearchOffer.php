<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchOfferRepository")
 */
class SearchOffer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="searchOffers")
     * @ORM\JoinColumn(name="id_category", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarMark", inversedBy="searchOffers")
     */
    private $mark;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarModel", inversedBy="searchOffers")
     * @Assert\NotBlank()
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subcategories", inversedBy="searchOffer")
     * @Assert\NotBlank()
     */
    private $subcategory;

    /**
     * @ORM\Column(type="boolean")
     */
    private $selectSubcategory;

    /**
     * @ORM\Column(type="boolean")
     */
    private $selectModel;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMark(): ?CarMark
    {
        return $this->mark;
    }

    public function setMark(?CarMark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getModel(): ?CarModel
    {
        return $this->model;
    }

    public function setModel(?CarModel $model): self
    {
        $this->model = $model;

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

    public function getSelectSubcategory(): ?bool
    {
        return $this->selectSubcategory;
    }

    public function setSelectSubcategory(bool $selectSubcategory): self
    {
        $this->selectSubcategory = $selectSubcategory;

        return $this;
    }

    public function getSelectModel(): ?bool
    {
        return $this->selectModel;
    }

    public function setSelectModel(bool $selectModel): self
    {
        $this->selectModel = $selectModel;

        return $this;
    }
}
