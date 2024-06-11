<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @var Collection<int, AcceptedQuest>
     */
    #[ORM\OneToMany(targetEntity: AcceptedQuest::class, mappedBy: 'player')]
    private Collection $acceptedQuests;

    /**
     * @var Collection<int, PlayerEffect>
     */
    #[ORM\OneToMany(targetEntity: PlayerEffect::class, mappedBy: 'player')]
    private Collection $playerEffects;

    public function __construct()
    {
        $this->inventorySlots = new ArrayCollection();
        $this->acceptedQuests = new ArrayCollection();
        $this->playerEffects = new ArrayCollection();
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

    /**
     * @return Collection<int, AcceptedQuest>
     */
    public function getAcceptedQuests(): Collection
    {
        return $this->acceptedQuests;
    }

    public function addAcceptedQuest(AcceptedQuest $acceptedQuest): static
    {
        if (!$this->acceptedQuests->contains($acceptedQuest)) {
            $this->acceptedQuests->add($acceptedQuest);
            $acceptedQuest->setPlayer($this);
        }

        return $this;
    }

    public function removeAcceptedQuest(AcceptedQuest $acceptedQuest): static
    {
        if ($this->acceptedQuests->removeElement($acceptedQuest)) {
            // set the owning side to null (unless already changed)
            if ($acceptedQuest->getPlayer() === $this) {
                $acceptedQuest->setPlayer(null);
            }
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

    public function createPlayerEffect(Effect $effect, EntityManagerInterface $entityManager): PlayerEffect {
        $playerEffect = new PlayerEffect();
        $playerEffect->setPlayer($this);
        $playerEffect->setEffect($effect);
        $playerEffect->setDebuffDuration($effect->getDebuffDuration());

        $entityManager->persist($playerEffect);

        return $playerEffect;
    }

    public function addPlayerEffect(PlayerEffect $playerEffect): static
    {
        if (!$this->playerEffects->contains($playerEffect)) {
            $this->playerEffects->add($playerEffect);
            $playerEffect->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerEffect(PlayerEffect $playerEffect): static
    {
        if ($this->playerEffects->removeElement($playerEffect)) {
            // set the owning side to null (unless already changed)
            if ($playerEffect->getPlayer() === $this) {
                $playerEffect->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * Update all the effects linked to the player. All available properties:
     * - Health
     * - Dabloons
     * - Distance
     * - InventoryMax
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    public function updatePlayerEffects(EntityManagerInterface $entityManager): void
    {
        $player = $this;
        foreach ($this->getPlayerEffects() as $playerEffect) {//Loop through Player Effects to apply all effect changes if the duration is longer.
            $effect = $playerEffect->getEffect();
            $property = $effect->getAffectedPlayerProperty();
            $changeValue = $effect->getEffectValueSeverity();
            $debuffDuration = $playerEffect->getDebuffDuration();

            //Check through the available changeable properties and change the player.
            //!!!IF THIS CASE GETS UPDATED, BE SURE TO UPDATE THE EFFECTTYPE FORM PLAYER PROPERTY!!!
            switch ($property) {
                case 'health':
                    $player->setHealth($player->getHealth() + $changeValue);
                    break;
                case 'dabloons':
                    $player->setDabloons($player->getDabloons() + $changeValue);
                    break;
                case 'distance':
                    $player->setDistance($player->getDistance() + $changeValue);
                    break;
                case 'inventoryMax':
                    $player->setInventoryMax($player->getInventoryMax() + $changeValue);
                    break;
            }

            $playerEffect->setDebuffDuration($debuffDuration - 1);//Decrease duration by one

            if ($debuffDuration <= 0) {//If effect duration reaches 0, remove the effect.
                $entityManager->remove($playerEffect);
            }

            $entityManager->persist($playerEffect);
        }
    }
}
