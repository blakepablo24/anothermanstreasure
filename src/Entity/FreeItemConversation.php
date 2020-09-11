<?php

namespace App\Entity;

use App\Repository\FreeItemConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="free_item_conversations")
 * @ORM\Entity(repositoryClass=FreeItemConversationRepository::class)
 */
class FreeItemConversation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=FreeItem::class, inversedBy="freeItemConversations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $FreeItem;

    /**
     * @ORM\OneToMany(targetEntity=ConversationMessage::class, mappedBy="Conversation")
     */
    private $conversationMessages;

    public function __construct()
    {
        $this->conversationMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $conversationMessage->setConversation($this);
        }

        return $this;
    }

    public function removeConversationMessage(ConversationMessage $conversationMessage): self
    {
        if ($this->conversationMessages->contains($conversationMessage)) {
            $this->conversationMessages->removeElement($conversationMessage);
            // set the owning side to null (unless already changed)
            if ($conversationMessage->getConversation() === $this) {
                $conversationMessage->setConversation(null);
            }
        }

        return $this;
    }

}
