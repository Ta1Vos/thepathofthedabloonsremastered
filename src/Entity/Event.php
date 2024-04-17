<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $eventText = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $options = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventText(): ?string
    {
        return $this->eventText;
    }

    public function setEventText(string $eventText): static
    {
        $this->eventText = $eventText;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }
}
