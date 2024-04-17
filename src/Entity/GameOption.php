<?php

namespace App\Entity;

use App\Repository\GameOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameOptionRepository::class)]
class GameOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $luckEnabled = null;

    #[ORM\Column]
    private ?bool $dialogueSkips = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLuckEnabled(): ?bool
    {
        return $this->luckEnabled;
    }

    public function setLuckEnabled(bool $luckEnabled): static
    {
        $this->luckEnabled = $luckEnabled;

        return $this;
    }

    public function isDialogueSkips(): ?bool
    {
        return $this->dialogueSkips;
    }

    public function setDialogueSkips(bool $dialogueSkips): static
    {
        $this->dialogueSkips = $dialogueSkips;

        return $this;
    }
}
