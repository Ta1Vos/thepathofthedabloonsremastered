<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Option name must be at least {{ limit }} characters long',
        maxMessage: 'Option name cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'options')]
    private Collection $events;

    #[ORM\ManyToOne(inversedBy: 'options')]
    private ?Quest $quests = null;

    public function __construct()
    {
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
            $event->addOption($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeOption($this);
        }

        return $this;
    }

    public function getQuests(): ?Quest
    {
        return $this->quests;
    }

    public function setQuests(?Quest $quests): static
    {
        $this->quests = $quests;

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
