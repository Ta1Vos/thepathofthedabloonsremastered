<?php

namespace App\Entity;

use App\Repository\EffectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
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

    //TRY TO IMPLEMENT PLAYERSTAT TYPE IN HERE INSTEAD OF USING SEPARATE ENTITY

    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[ORM\Column]
    private ?int $debuffDuration = null;

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

    /**
     * @var Collection<int, PlayerEffect>
     */
    #[ORM\OneToMany(targetEntity: PlayerEffect::class, mappedBy: 'effect')]
    private Collection $playerEffects;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $affectedPlayerProperty = null;

    #[ORM\Column]
    private ?int $effectValueSeverity = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->playerEffects = new ArrayCollection();
        $this->propertyChanges = new ArrayCollection();
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

    public function getDebuffDuration(): ?int
    {
        return $this->debuffDuration;
    }

    public function setDebuffDuration(int $debuffDuration): static
    {
        $this->debuffDuration = $debuffDuration;

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

    /**
     * @return Collection<int, PlayerEffect>
     */
    public function getPlayerEffects(): Collection
    {
        return $this->playerEffects;
    }

    public function createPlayerEffect(Player $player, EntityManagerInterface $entityManager): PlayerEffect {
        $playerEffect = new PlayerEffect();
        $playerEffect->setPlayer($player);
        $playerEffect->setEffect($this);
        $playerEffect->setDebuffDuration($this->getDebuffDuration());

        $entityManager->persist($playerEffect);

        return $playerEffect;
    }

    public function addPlayerEffect(PlayerEffect $playerEffect): static
    {
        if (!$this->playerEffects->contains($playerEffect)) {
            $this->playerEffects->add($playerEffect);
            $playerEffect->setEffect($this);
        }

        return $this;
    }

    public function removePlayerEffect(PlayerEffect $playerEffect): static
    {
        if ($this->playerEffects->removeElement($playerEffect)) {
            // set the owning side to null (unless already changed)
            if ($playerEffect->getEffect() === $this) {
                $playerEffect->setEffect(null);
            }
        }

        return $this;
    }

    public function getAffectedPlayerProperty(): ?string
    {
        return $this->affectedPlayerProperty;
    }

    public function setAffectedPlayerProperty(?string $affectedPlayerProperty): static
    {
        $this->affectedPlayerProperty = $affectedPlayerProperty;

        return $this;
    }

    public function getEffectValueSeverity(): ?int
    {
        return $this->effectValueSeverity;
    }

    public function setEffectValueSeverity(int $effectValueSeverity): static
    {
        $this->effectValueSeverity = $effectValueSeverity;

        return $this;
    }
}
