<?php

namespace App\Entity;

use App\Repository\EffectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EffectRepository::class)]
class Effect
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $debuffSeverity = null;

    #[ORM\Column]
    private ?int $debuffDuration = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $debuffs = [];

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

    public function getDebuffs(): array
    {
        return $this->debuffs;
    }

    public function setDebuffs(array $debuffs): static
    {
        $this->debuffs = $debuffs;

        return $this;
    }
}
