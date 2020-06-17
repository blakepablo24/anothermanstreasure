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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=FreeItem::class, inversedBy="freeItemPictures")
     */
    private $FreeItem;

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

    public function getFreeItem(): ?FreeItem
    {
        return $this->FreeItem;
    }

    public function setFreeItem(?FreeItem $FreeItem): self
    {
        $this->FreeItem = $FreeItem;

        return $this;
    }
}
