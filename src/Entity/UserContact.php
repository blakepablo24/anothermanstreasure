<?php

namespace App\Entity;

use App\Repository\UserContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserContactRepository::class)
 */
class UserContact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_line_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_line_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_line_3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_post_code;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userContact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getAddressLine1(): ?string
    {
        return $this->address_line_1;
    }

    public function setAddressLine1(?string $address_line_1): self
    {
        $this->address_line_1 = $address_line_1;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->address_line_2;
    }

    public function setAddressLine2(?string $address_line_2): self
    {
        $this->address_line_2 = $address_line_2;

        return $this;
    }

    public function getAddressLine3(): ?string
    {
        return $this->address_line_3;
    }

    public function setAddressLine3(?string $address_line_3): self
    {
        $this->address_line_3 = $address_line_3;

        return $this;
    }

    public function getAddressPostCode(): ?string
    {
        return $this->address_post_code;
    }

    public function setAddressPostCode(?string $address_post_code): self
    {
        $this->address_post_code = $address_post_code;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
