<?php

namespace App\Entity;

use App\Repository\FreeItemRepository;
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture01;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture02;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture03;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture04;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture05;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture06;

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

    public function getPicture01(): ?string
    {
        return $this->picture01;
    }

    public function setPicture01(?string $picture01): self
    {
        $this->picture01 = $picture01;

        return $this;
    }

    public function getPicture02(): ?string
    {
        return $this->picture02;
    }

    public function setPicture02(?string $picture02): self
    {
        $this->picture02 = $picture02;

        return $this;
    }

    public function getPicture03(): ?string
    {
        return $this->picture03;
    }

    public function setPicture03(?string $picture03): self
    {
        $this->picture03 = $picture03;

        return $this;
    }

    public function getPicture04(): ?string
    {
        return $this->picture04;
    }

    public function setPicture04(?string $picture04): self
    {
        $this->picture04 = $picture04;

        return $this;
    }

    public function getPicture05(): ?string
    {
        return $this->picture05;
    }

    public function setPicture05(?string $picture05): self
    {
        $this->picture05 = $picture05;

        return $this;
    }

    public function getPicture06(): ?string
    {
        return $this->picture06;
    }

    public function setPicture06(?string $picture06): self
    {
        $this->picture06 = $picture06;

        return $this;
    }
}
