<?php

namespace App\Entity;

use App\Repository\QuestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestRepository::class)]
class Quest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $questText = null;

    #[ORM\Column]
    private ?int $dabloonReward = null;

    #[ORM\Column]
    private ?bool $isCompleted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestText(): ?string
    {
        return $this->questText;
    }

    public function setQuestText(string $questText): static
    {
        $this->questText = $questText;

        return $this;
    }

    public function getDabloonReward(): ?int
    {
        return $this->dabloonReward;
    }

    public function setDabloonReward(int $dabloonReward): static
    {
        $this->dabloonReward = $dabloonReward;

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }
}
