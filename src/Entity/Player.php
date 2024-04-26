<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(mappedBy: 'player', cascade: ['persist', 'remove'])]
    private ?GameOption $gameOption = null;

    #[ORM\ManyToOne(inversedBy: 'player')]
    private ?User $user = null;

    /**
     * @var Collection<int, InventorySlot>
     */
    #[ORM\OneToMany(targetEntity: InventorySlot::class, mappedBy: 'player')]
    private Collection $inventorySlots;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?World $world = null;

    public function __construct()
    {
        $this->inventorySlots = new ArrayCollection();
    }

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

    public function getGameOption(): ?GameOption
    {
        return $this->gameOption;
    }

    public function setGameOption(GameOption $gameOption): static
    {
        // set the owning side of the relation if necessary
        if ($gameOption->getPlayer() !== $this) {
            $gameOption->setPlayer($this);
        }

        $this->gameOption = $gameOption;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, InventorySlot>
     */
    public function getInventorySlots(): Collection
    {
        return $this->inventorySlots;
    }

    public function addInventorySlot(InventorySlot $inventorySlot): static
    {
        if (!$this->inventorySlots->contains($inventorySlot)) {
            $this->inventorySlots->add($inventorySlot);
            $inventorySlot->setPlayer($this);
        }

        return $this;
    }

    public function removeInventorySlot(InventorySlot $inventorySlot): static
    {
        if ($this->inventorySlots->removeElement($inventorySlot)) {
            // set the owning side to null (unless already changed)
            if ($inventorySlot->getPlayer() === $this) {
                $inventorySlot->setPlayer(null);
            }
        }

        return $this;
    }

    public function getWorld(): ?World
    {
        return $this->world;
    }

    public function setWorld(?World $world): static
    {
        $this->world = $world;

        return $this;
    }
}
