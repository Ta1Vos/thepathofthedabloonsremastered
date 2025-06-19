<?php

namespace App\Entity;

use App\Repository\PlayerEffectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerEffectRepository::class)]
class PlayerEffect
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $debuffDuration = null;

    #[ORM\ManyToOne(inversedBy: 'playerEffects')]
    private ?Player $player = null;

    #[ORM\ManyToOne(inversedBy: 'playerEffects')]
    private ?Effect $effect = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebuffDuration(): ?int
    {
        return $this->debuffDuration;
    }

    public function setDebuffDuration(int $debuffDuration): static
    {
        $this->debuffDuration = $debuffDuration;

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

    public function getEffect(): ?Effect
    {
        return $this->effect;
    }

    public function setEffect(?Effect $effect): static
    {
        $this->effect = $effect;

        return $this;
    }
}
