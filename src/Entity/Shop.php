<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
class Shop implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $additionalLuck = null;

    #[ORM\Column]
    private ?int $additionalPrice = null;

    #[ORM\Column]
    private ?int $itemAmount = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'shop')]
    private Collection $linkedEvents;

    #[ORM\ManyToOne(inversedBy: 'shops')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rarity $rarity = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'shops')]
    private Collection $guaranteedItems;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Shop name must be at least {{ limit }} characters long',
        maxMessage: 'Shop name cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->linkedEvents = new ArrayCollection();
        $this->guaranteedItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdditionalLuck(): ?int
    {
        return $this->additionalLuck;
    }

    public function setAdditionalLuck(int $additionalLuck): static
    {
        $this->additionalLuck = $additionalLuck;

        return $this;
    }

    public function getAdditionalPrice(): ?int
    {
        return $this->additionalPrice;
    }

    public function setAdditionalPrice(int $additionalPrice): static
    {
        $this->additionalPrice = $additionalPrice;

        return $this;
    }

    public function getItemAmount(): ?int
    {
        return $this->itemAmount;
    }

    public function setItemAmount(int $itemAmount): static
    {
        $this->itemAmount = $itemAmount;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getLinkedEvents(): Collection
    {
        return $this->linkedEvents;
    }

    public function addLinkedEvent(Event $linkedEvent): static
    {
        if (!$this->linkedEvents->contains($linkedEvent)) {
            $this->linkedEvents->add($linkedEvent);
            $linkedEvent->setShop($this);
        }

        return $this;
    }

    public function removeLinkedEvent(Event $linkedEvent): static
    {
        if ($this->linkedEvents->removeElement($linkedEvent)) {
            // set the owning side to null (unless already changed)
            if ($linkedEvent->getShop() === $this) {
                $linkedEvent->setShop(null);
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
     * @return Collection<int, Item>
     */
    public function getGuaranteedItems(): Collection
    {
        return $this->guaranteedItems;
    }

    public function addGuaranteedItem(Item $guaranteedItem): static
    {
        if (!$this->guaranteedItems->contains($guaranteedItem)) {
            $this->guaranteedItems->add($guaranteedItem);
        }

        return $this;
    }

    public function removeGuaranteedItem(Item $guaranteedItem): static
    {
        $this->guaranteedItems->removeElement($guaranteedItem);

        return $this;
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

    public function generateItems(): static {
        $rarity = $this->getRarity();


        return $this;
    }

    public function jsonSerialize(): mixed
    {
       return [
           'name' => $this->getName(),
           'additionalLuck' => $this->getAdditionalLuck(),
           'additionalPrice' => $this->getAdditionalPrice(),

       ];
    }

    public function getJSONFormat(bool $toJson = true): array|string {
        $array = [];
        foreach ($this as $key => $value) {
            $type = gettype($value);
            if ($type != "object" && $type != "unknown type") $array[$key] = $value; //Do not grab collection items, these will not be used.
        }

        if ($toJson) return json_encode($array);

        return $array;
    }
}
