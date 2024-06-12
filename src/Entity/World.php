<?php

namespace App\Entity;

use App\Repository\WorldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WorldRepository::class)]
class World
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 150,
        minMessage: 'World name must be at least {{ limit }} characters long',
        maxMessage: 'World name cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[Assert\NotNull]
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    #[ORM\Column]
    private ?int $distanceLimit = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'worlds')]
    private Collection $events;

    /**
     * @var Collection<int, Player>
     */
    #[ORM\OneToMany(targetEntity: Player::class, mappedBy: 'world')]
    private Collection $players;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->players = new ArrayCollection();
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

    public function getDistanceLimit(): ?int
    {
        return $this->distanceLimit;
    }

    public function setDistanceLimit(int $distanceLimit): static
    {
        $this->distanceLimit = $distanceLimit;

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
            $event->addWorld($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeWorld($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setWorld($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getWorld() === $this) {
                $player->setWorld(null);
            }
        }

        return $this;
    }
}
