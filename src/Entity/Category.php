<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name="categories")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This category already exists!"
 * )
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=FreeItem::class, mappedBy="category")
     */
    private $freeItems;

    public function __construct()
    {
        $this->freeItems = new ArrayCollection();
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
     * @return Collection|FreeItem[]
     */
    public function getFreeItems(): Collection
    {
        return $this->freeItems;
    }

    public function addFreeItem(FreeItem $freeItem): self
    {
        if (!$this->freeItems->contains($freeItem)) {
            $this->freeItems[] = $freeItem;
            $freeItem->setCategory($this);
        }

        return $this;
    }

    public function removeFreeItem(FreeItem $freeItem): self
    {
        if ($this->freeItems->contains($freeItem)) {
            $this->freeItems->removeElement($freeItem);
            // set the owning side to null (unless already changed)
            if ($freeItem->getCategory() === $this) {
                $freeItem->setCategory(null);
            }
        }

        return $this;
    }
}
