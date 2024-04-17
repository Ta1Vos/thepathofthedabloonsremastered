<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $health = null;

    #[ORM\Column]
    private ?int $dabloons = null;

    #[ORM\Column]
    private ?int $distance = null;

    #[ORM\Column]
    private ?int $inventoryMax = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastSave = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): static
    {
        $this->health = $health;

        return $this;
    }

    public function getDabloons(): ?int
    {
        return $this->dabloons;
    }

    public function setDabloons(int $dabloons): static
    {
        $this->dabloons = $dabloons;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    public function getInventoryMax(): ?int
    {
        return $this->inventoryMax;
    }

    public function setInventoryMax(int $inventoryMax): static
    {
        $this->inventoryMax = $inventoryMax;

        return $this;
    }

    public function getLastSave(): ?\DateTimeInterface
    {
        return $this->lastSave;
    }

    public function setLastSave(\DateTimeInterface $lastSave): static
    {
        $this->lastSave = $lastSave;

        return $this;
    }
}
