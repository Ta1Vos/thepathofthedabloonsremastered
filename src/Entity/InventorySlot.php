<?php

namespace App\Entity;

use App\Repository\InventorySlotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventorySlotRepository::class)]
class InventorySlot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $effectIsActive = null;

    #[ORM\Column(length: 10)]
    private ?string $debuffSeverity = null;

    #[ORM\Column]
    private ?int $debuffDuration = null;

    #[ORM\ManyToOne(inversedBy: 'inventorySlots')]
    private ?Player $player = null;

    #[ORM\ManyToOne(inversedBy: 'inventorySlots')]
    private ?Item $item = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEffectIsActive(): ?bool
    {
        return $this->effectIsActive;
    }

    public function setEffectIsActive(bool $effectIsActive): static
    {
        $this->effectIsActive = $effectIsActive;

        return $this;
    }

    public function getDebuffSeverity(): ?string
    {
        return $this->debuffSeverity;
    }

    public function setDebuffSeverity(string $debuffSeverity): static
    {
        $this->debuffSeverity = $debuffSeverity;

        return $this;
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

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): static
    {
        $this->item = $item;

        return $this;
    }
}
