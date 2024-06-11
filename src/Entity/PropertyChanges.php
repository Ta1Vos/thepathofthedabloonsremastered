<?php

namespace App\Entity;

use App\Repository\PropertyChangesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
//Property changes have to be set to change player (or other entity) values through the Effect entity. The Effect entity will also handle the
//information received from the PropertyChanges entity.
#[ORM\Entity(repositoryClass: PropertyChangesRepository::class)]
class PropertyChanges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $playerProperty = null;

    #[ORM\Column]
    private ?int $changeValue = null;

    /**
     * @var Collection<int, Effect>
     */
    #[ORM\ManyToMany(targetEntity: Effect::class, inversedBy: 'propertyChanges')]
    private Collection $effects;

    public function __construct()
    {
        $this->effects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerProperty(): ?string
    {
        return $this->playerProperty;
    }

    public function setPlayerProperty(?string $playerProperty): static
    {
        $this->playerProperty = $playerProperty;

        return $this;
    }

    public function getChangeValue(): ?int
    {
        return $this->changeValue;
    }

    public function setChangeValue(int $changeValue): static
    {
        $this->changeValue = $changeValue;

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
}
