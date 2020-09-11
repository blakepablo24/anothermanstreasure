<?php

namespace App\Entity;

use App\Repository\ConversationMessageRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="conversation_messages")
 * @ORM\Entity(repositoryClass=ConversationMessageRepository::class)
 */
class ConversationMessage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=FreeItemConversation::class, inversedBy="conversationMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Conversation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conversationMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\Column(type="time")
     */
    private $Time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConversation(): ?FreeItemConversation
    {
        return $this->Conversation;
    }

    public function setConversation(?FreeItemConversation $Conversation): self
    {
        $this->Conversation = $Conversation;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->Time;
    }

    public function setTime(\DateTimeInterface $Time): self
    {
        $this->Time = $Time;

        return $this;
    }
}
