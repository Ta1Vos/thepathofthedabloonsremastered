<?php

namespace App\Entity;

use App\Repository\EffectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EffectRepository::class)]
class Effect
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 100,
        minMessage: 'Effect name must be at least {{ limit }} characters long',
        maxMessage: 'Effect name cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 10,
        minMessage: 'Debuff severity must be at least {{ limit }} characters long',
        maxMessage: 'Debuff severity cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column(length: 10)]
    private ?string $debuffSeverity = null;

    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[ORM\Column]
    private ?int $debuffDuration = null;

    //THERE HAS TO BE A DIRECT LINK WITH PLAYER PROPERTIES, ASK THE TEACHER HOW TO LINK IT THROUGH A VARIABLE.
    #[ORM\Column(type: Types::ARRAY)]
    private array $debuffs = [];

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, mappedBy: 'effects')]
    private Collection $items;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'effects')]
    private Collection $events;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->addEffect($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            $item->removeEffect($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addEffect($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeEffect($this);
        }

        return $this;
    }
}
