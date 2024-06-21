<?php

namespace App\Entity;

use App\Repository\DialogueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DialogueRepository::class)]
class Dialogue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $dialogueText;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Dialogue name must be at least {{ limit }} characters long',
        maxMessage: 'Dialogue name cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'dialogues')]
    private Collection $events;

    #[ORM\ManyToOne(inversedBy: 'previousForcedDialogue')]
    private ?Event $nextEvent = null;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDialogueText(): ?string
    {
        return $this->dialogueText;
    }

    public function setDialogueText(string $dialogueText): static
    {
        $this->dialogueText = $dialogueText;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
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
            $event->addDialogue($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeDialogue($this);
        }

        return $this;
    }

    public function getNextEvent(): ?Event
    {
        return $this->nextEvent;
    }

    public function setNextEvent(?Event $nextEvent): static
    {
        $this->nextEvent = $nextEvent;

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
