<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column]
    private ?bool $isWeapon = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $debuffSeverity = null;

    #[ORM\Column(nullable: true)]
    private ?int $debuffDuration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isWeapon(): ?bool
    {
        return $this->isWeapon;
    }

    public function setWeapon(bool $isWeapon): static
    {
        $this->isWeapon = $isWeapon;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDebuffSeverity(): ?string
    {
        return $this->debuffSeverity;
    }

    public function setDebuffSeverity(?string $debuffSeverity): static
    {
        $this->debuffSeverity = $debuffSeverity;

        return $this;
    }

    public function getDebuffDuration(): ?int
    {
        return $this->debuffDuration;
    }

    public function setDebuffDuration(?int $debuffDuration): static
    {
        $this->debuffDuration = $debuffDuration;

        return $this;
    }
}
