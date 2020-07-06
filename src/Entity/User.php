<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")
 * @UniqueEntity("email")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "Please enter a avalid email address.")
     * @Assert\Email()
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @Assert\NotBlank(message = "Please enter a valid password.")
     * @Assert\Length(max=4096)
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message = "Valid first name is required.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message = "Valid first name is required.")
     */
    private $last_name;

    /**
     * @ORM\OneToMany(targetEntity=FreeItem::class, mappedBy="user")
     */
    private $freeItems;

    /**
     * @ORM\OneToOne(targetEntity=UserContact::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userContact;

    public function __construct()
    {
        $this->freeItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

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
            $freeItem->setUser($this);
        }

        return $this;
    }

    public function removeFreeItem(FreeItem $freeItem): self
    {
        if ($this->freeItems->contains($freeItem)) {
            $this->freeItems->removeElement($freeItem);
            // set the owning side to null (unless already changed)
            if ($freeItem->getUser() === $this) {
                $freeItem->setUser(null);
            }
        }

        return $this;
    }

    public function getUserContact(): ?UserContact
    {
        return $this->userContact;
    }

    public function setUserContact(UserContact $userContact): self
    {
        $this->userContact = $userContact;

        // set the owning side of the relation if necessary
        if ($userContact->getUser() !== $this) {
            $userContact->setUser($this);
        }

        return $this;
    }
}
