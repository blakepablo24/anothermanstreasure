<?php

namespace App\Entity;

use App\Repository\FreeItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index as Index;

/**
 * @ORM\Entity(repositoryClass=FreeItemRepository::class)
 * @ORM\Table(name="freeitems", indexes={@Index(name="title_idx", columns={"title"})})
 */
class FreeItem
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="freeItems")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=FreeItemPictures::class, mappedBy="FreeItem", orphanRemoval=true)
     */
    private $freeItemPictures;

    public function __construct()
    {
        $this->freeItemPictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|FreeItemPictures[]
     */
    public function getFreeItemPictures(): Collection
    {
        return $this->freeItemPictures;
    }

    public function addFreeItemPicture(FreeItemPictures $freeItemPicture): self
    {
        if (!$this->freeItemPictures->contains($freeItemPicture)) {
            $this->freeItemPictures[] = $freeItemPicture;
            $freeItemPicture->setFreeItem($this);
        }

        return $this;
    }

    public function removeFreeItemPicture(FreeItemPictures $freeItemPicture): self
    {
        if ($this->freeItemPictures->contains($freeItemPicture)) {
            $this->freeItemPictures->removeElement($freeItemPicture);
            // set the owning side to null (unless already changed)
            if ($freeItemPicture->getFreeItem() === $this) {
                $freeItemPicture->setFreeItem(null);
            }
        }

        return $this;
    }
}
