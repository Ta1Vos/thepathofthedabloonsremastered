<?php

namespace App\Entity;

use App\Repository\AcceptedQuestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcceptedQuestRepository::class)]
class AcceptedQuest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isCompleted = null;

    #[ORM\ManyToOne(inversedBy: 'acceptedQuests')]
    private ?Quest $quest = null;

    #[ORM\ManyToOne(inversedBy: 'acceptedQuests')]
    private ?Player $player = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setCompleted(?bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getQuest(): ?Quest
    {
        return $this->quest;
    }

    public function setQuest(?Quest $quest): static
    {
        $this->quest = $quest;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): static
    {
        $this->player = $player;

        return $this;
    }
}
