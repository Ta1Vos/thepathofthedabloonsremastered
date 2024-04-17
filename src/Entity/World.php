<?php

namespace App\Entity;

use App\Repository\WorldRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorldRepository::class)]
class World
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $distanceLimit = null;

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

    public function getDistanceLimit(): ?int
    {
        return $this->distanceLimit;
    }

    public function setDistanceLimit(int $distanceLimit): static
    {
        $this->distanceLimit = $distanceLimit;

        return $this;
    }
}
