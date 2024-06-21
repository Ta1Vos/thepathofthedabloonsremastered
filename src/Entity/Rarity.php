<?php

namespace App\Entity;

use App\Repository\RarityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RarityRepository::class)]
#[UniqueEntity(fields: ['priority'], message: 'This priority is already in use.')]
class Rarity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: 'Rarity name must be at least {{ limit }} characters long',
        maxMessage: 'Rarity name cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[Assert\NotNull]
    #[Assert\Range(
        notInRangeMessage: 'Minimum chance is {{ min }}% and maximum chance is {{ max }}%',
        min: 0,
        max: 100
    )]
    #[ORM\Column]
    private ?int $chanceIn = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'rarity')]
    private Collection $items;

    #[Assert\NotNull]
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    #[ORM\Column(unique: true)]
    private ?int $priority;

    /**
     * @var Collection<int, Shop>
     */
    #[ORM\OneToMany(targetEntity: Shop::class, mappedBy: 'rarity')]
    private Collection $shops;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->shops = new ArrayCollection();
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

    public function getChanceIn(): ?int
    {
        return $this->chanceIn;
    }

    public function setChanceIn(int $chanceIn): static
    {
        $this->chanceIn = $chanceIn;

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
            $item->setRarity($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getRarity() === $this) {
                $item->setRarity(null);
            }
        }

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return Collection<int, Shop>
     */
    public function getShops(): Collection
    {
        return $this->shops;
    }

    public function addShop(Shop $shop): static
    {
        if (!$this->shops->contains($shop)) {
            $this->shops->add($shop);
            $shop->setRarity($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): static
    {
        if ($this->shops->removeElement($shop)) {
            // set the owning side to null (unless already changed)
            if ($shop->getRarity() === $this) {
                $shop->setRarity(null);
            }
        }

        return $this;
    }

    private function getOrderedRarities(EntityManagerInterface $entityManager)
    {
        return $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Rarity p 
            WHERE p.priority > 0
            ORDER BY p.priority ASC'
        )->getResult();
    }

    private function calcRarityLuckInfluence(int $luck, array $rarities, EntityManagerInterface $entityManager, $rarityMax): array
    {
        $avgRarityChance = floor($rarityMax / count($rarities));
        $removeChances = 0;
//        dd($rarities);

        foreach ($rarities as $rarity) {
            if (!is_a($rarity, Rarity::class)) break; //Kill the foreach loop if rarities does not contain only Rarity class
            $chance = $rarity->getChanceIn();
            if ($chance > $avgRarityChance && $luck > 0) {
                //Calculate the influence of positive luck. Luck will try to equalize the chances you have with all the rarities, by lowering the rarity chances above the average and spreading it over the other rarities.
                $calculatedChance = floor($luck ** 2 / ($luck / 2));
//                if ($chance < $avgRarityChance * 1.15) { //More balancing for rare rarities? Decrease less chance for rare rarities.
//                    $calculatedChance = $calculatedChance - $calculatedChance / 5;
//                }

                while ($chance - $calculatedChance < 0) {//Make sure nothing goes into negatives
                    $calculatedChance-= 0.1;
                }

                $rarity->setChanceIn($chance - $calculatedChance);//Remove the luck from the balanced rarity
                $chanceToBeAdded = ceil($calculatedChance / count($rarities));
                foreach ($rarities as $changingRarity) {
                    $changingRarity->setChanceIn($changingRarity->getChanceIn() + $chanceToBeAdded);
                }

            } else {//Calculate the influence of negative luck. Ignore the rarity with the highest priority
                $toBeRemoved = ceil($chance * (-0.1 * $luck));//Remove a quarter from each chance value.
                $removeChances += $toBeRemoved;//Add the removed chances to the more common rarity.
                $rarity->setChanceIn($chance - $toBeRemoved);
            }
        }

        if (is_a($rarities[0], Rarity::class)) {
            $rarities[0]->setChanceIn($rarities[0]->getChanceIn() + $removeChances);//Add the chances removed from the lower priority rarities.
        }

        dd($rarities);

        return $rarities;
    }

    /**
     * Generate a rarity with the influence of the current rarity. This will mainly be used
     * for the Shop feature in this project.
     * @return array
     */
    public function generateRarity(int $luck, EntityManagerInterface $entityManager, Shop $shop = null): Rarity
    {
        $rarities = $this->getOrderedRarities($entityManager);

        if ($shop) {
            $luck += $shop->getAdditionalLuck();
        }

        $rarityMax = 0;
        foreach ($rarities as $rarity) {
            $rarityMax += $rarity->getChanceIn();
        }

        if ($luck != 0) {
            $rarities = $this->calcRarityLuckInfluence($luck, $rarities, $entityManager, $rarityMax);
        }

        $rarityMax = 0;
        foreach ($rarities as $rarity) {//Recalculate the rarity max
            $rarityMax += $rarity->getChanceIn();
        }

        $generatedRarity = null;

        $rNum = rand(0, $rarityMax + 1);

        $counted = 0;

        foreach ($rarities as $rarity) {
            if ($rNum <= $rarity->getChanceIn() + $counted + 1) {
                $generatedRarity = $rarity;
                break;
            } else {
                $counted += $rarity->getChanceIn();
            }
        }

//        echo $rNum . '   ';

        return $generatedRarity;
    }

    public function generateItem(): Item
    {
        $items = $this->getItems();
        $index = rand(0, count($items) - 1);

        return $items[$index];
    }
}
