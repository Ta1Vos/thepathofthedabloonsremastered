<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $eventText = null;


    /**
     * @var Collection<int, Effect>
     */
    #[ORM\ManyToMany(targetEntity: Effect::class, inversedBy: 'events')]
    private Collection $effects;

    /**
     * @var Collection<int, Dialogue>
     */
    #[ORM\ManyToMany(targetEntity: Dialogue::class, inversedBy: 'events')]
    private Collection $dialogues;

    /**
     * @var Collection<int, Option>
     */
    #[ORM\ManyToMany(targetEntity: Option::class, inversedBy: 'events')]
    private Collection $options;

    /**
     * @var Collection<int, World>
     */
    #[ORM\ManyToMany(targetEntity: World::class, inversedBy: 'events')]
    private Collection $worlds;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Event name must be at least {{ limit }} characters long',
        maxMessage: 'Event name cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'linkedEvents')]
    private ?Shop $shop = null;

    /**
     * @var Collection<int, Dialogue>
     */
    #[ORM\OneToMany(targetEntity: Dialogue::class, mappedBy: 'nextEvent')]
    private Collection $previousForcedDialogue;

    public function __construct()
    {
        $this->effects = new ArrayCollection();
        $this->dialogues = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->worlds = new ArrayCollection();
        $this->previousForcedDialogue = new ArrayCollection();
    }

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
     * @return Collection<int, Dialogue>
     */
    public function getDialogues(): Collection
    {
        return $this->dialogues;
    }

    public function addDialogue(Dialogue $dialogue): static
    {
        if (!$this->dialogues->contains($dialogue)) {
            $this->dialogues->add($dialogue);
        }

        return $this;
    }

    public function removeDialogue(Dialogue $dialogue): static
    {
        $this->dialogues->removeElement($dialogue);

        return $this;
    }

    /**
     * @return Collection<int, Option>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): static
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
        }

        return $this;
    }

    public function removeOption(Option $option): static
    {
        $this->options->removeElement($option);

        return $this;
    }

    /**
     * @return Collection<int, World>
     */
    public function getWorlds(): Collection
    {
        return $this->worlds;
    }

    public function addWorld(World $world): static
    {
        if (!$this->worlds->contains($world)) {
            $this->worlds->add($world);
        }

        return $this;
    }

    public function removeWorld(World $world): static
    {
        $this->worlds->removeElement($world);

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

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): static
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * @return Collection<int, Dialogue>
     */
    public function getPreviousForcedDialogue(): Collection
    {
        return $this->previousForcedDialogue;
    }

    public function addPreviousForcedDialogue(Dialogue $previousForcedDialogue): static
    {
        if (!$this->previousForcedDialogue->contains($previousForcedDialogue)) {
            $this->previousForcedDialogue->add($previousForcedDialogue);
            $previousForcedDialogue->setNextEvent($this);
        }

        return $this;
    }

    public function removePreviousForcedDialogue(Dialogue $previousForcedDialogue): static
    {
        if ($this->previousForcedDialogue->removeElement($previousForcedDialogue)) {
            // set the owning side to null (unless already changed)
            if ($previousForcedDialogue->getNextEvent() === $this) {
                $previousForcedDialogue->setNextEvent(null);
            }
        }

        return $this;
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
