<?php

namespace App\Entity;

use App\Repository\FreeItemPicturesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FreeItemPicturesRepository::class)
 */
class FreeItemPictures
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=FreeItem::class, inversedBy="freeItemPictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $freeitem;

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

    public function getFreeitem(): ?FreeItem
    {
        return $this->freeitem;
    }

    public function setFreeitem(?FreeItem $freeitem): self
    {
        $this->freeitem = $freeitem;

        return $this;
    }
}
