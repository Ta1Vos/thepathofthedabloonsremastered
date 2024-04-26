<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, InventorySlot>
     */
    #[ORM\OneToMany(targetEntity: InventorySlot::class, mappedBy: 'item')]
    private Collection $inventorySlots;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Rarity $rarity = null;

    /**
     * @var Collection<int, Effect>
     */
    #[ORM\ManyToMany(targetEntity: Effect::class, inversedBy: 'items')]
    private Collection $effects;

    /**
     * @var Collection<int, Quest>
     */
    #[ORM\OneToMany(targetEntity: Quest::class, mappedBy: 'rewardedItem')]
    private Collection $quests;

    public function __construct()
    {
        $this->inventorySlots = new ArrayCollection();
        $this->effects = new ArrayCollection();
        $this->quests = new ArrayCollection();
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
            $inventorySlot->setItem($this);
        }

        return $this;
    }

    public function removeInventorySlot(InventorySlot $inventorySlot): static
    {
        if ($this->inventorySlots->removeElement($inventorySlot)) {
            // set the owning side to null (unless already changed)
            if ($inventorySlot->getItem() === $this) {
                $inventorySlot->setItem(null);
            }
        }

        return $this;
    }

    public function getRarity(): ?Rarity
    {
        return $this->rarity;
    }

    public function setRarity(?Rarity $rarity): static
    {
        $this->rarity = $rarity;

        return $this;
    }

    /**
     * @return Collection<int, Effect>
     */
    public function getEffects(): Collection
    {
        return $this->effects;
    }

    public function addEffect(Effect $effect): static
    {
        if (!$this->effects->contains($effect)) {
            $this->effects->add($effect);
        }

        return $this;
    }

    public function removeEffect(Effect $effect): static
    {
        $this->effects->removeElement($effect);

        return $this;
    }

    /**
     * @return Collection<int, Quest>
     */
    public function getQuests(): Collection
    {
        return $this->quests;
    }

    public function addQuest(Quest $quest): static
    {
        if (!$this->quests->contains($quest)) {
            $this->quests->add($quest);
            $quest->setRewardedItem($this);
        }

        return $this;
    }

    public function removeQuest(Quest $quest): static
    {
        if ($this->quests->removeElement($quest)) {
            // set the owning side to null (unless already changed)
            if ($quest->getRewardedItem() === $this) {
                $quest->setRewardedItem(null);
            }
        }

        return $this;
    }
}
