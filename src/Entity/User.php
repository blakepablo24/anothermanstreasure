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
     * @ORM\Column(type="string", length=11, nullable=true)
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
    private $address_town;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_county;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_post_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_free_ads;

    /**
     * @ORM\Column(type="date")
     */
    private $start_date;

    /**
     * @ORM\Column(type="time")
     */
    private $start_time;

    /**
     * @ORM\OneToMany(targetEntity=ConversationMessage::class, mappedBy="User")
     */
    private $conversationMessages;

    /**
     * @ORM\OneToMany(targetEntity=FreeItemConversation::class, mappedBy="enquiring_user")
     */
    private $freeItemConversations;

    public function __construct()
    {
        $this->conversationMessages = new ArrayCollection();
        $this->freeItemConversations = new ArrayCollection();
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

    public function getAddressTown(): ?string
    {
        return $this->address_town;
    }

    public function setAddressTown(?string $address_town): self
    {
        $this->address_town = $address_town;

        return $this;
    }

    public function getAddressCounty(): ?string
    {
        return $this->address_county;
    }

    public function setAddressCounty(?string $address_county): self
    {
        $this->address_county = $address_county;

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

    public function getTotalFreeAds(): ?int
    {
        return $this->total_free_ads;
    }

    public function setTotalFreeAds(int $total_free_ads): self
    {
        $this->total_free_ads = $total_free_ads;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    /**
     * @return Collection|ConversationMessage[]
     */
    public function getConversationMessages(): Collection
    {
        return $this->conversationMessages;
    }

    public function addConversationMessage(ConversationMessage $conversationMessage): self
    {
        if (!$this->conversationMessages->contains($conversationMessage)) {
            $this->conversationMessages[] = $conversationMessage;
            $conversationMessage->setUser($this);
        }

        return $this;
    }

    public function removeConversationMessage(ConversationMessage $conversationMessage): self
    {
        if ($this->conversationMessages->contains($conversationMessage)) {
            $this->conversationMessages->removeElement($conversationMessage);
            // set the owning side to null (unless already changed)
            if ($conversationMessage->getUser() === $this) {
                $conversationMessage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FreeItemConversation[]
     */
    public function getFreeItemConversations(): Collection
    {
        return $this->freeItemConversations;
    }

    public function addFreeItemConversation(FreeItemConversation $freeItemConversation): self
    {
        if (!$this->freeItemConversations->contains($freeItemConversation)) {
            $this->freeItemConversations[] = $freeItemConversation;
            $freeItemConversation->setEnquiringUser($this);
        }

        return $this;
    }

    public function removeFreeItemConversation(FreeItemConversation $freeItemConversation): self
    {
        if ($this->freeItemConversations->contains($freeItemConversation)) {
            $this->freeItemConversations->removeElement($freeItemConversation);
            // set the owning side to null (unless already changed)
            if ($freeItemConversation->getEnquiringUser() === $this) {
                $freeItemConversation->setEnquiringUser(null);
            }
        }

        return $this;
    }

}
