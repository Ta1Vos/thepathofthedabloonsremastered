<?php

namespace App\Entity;

use App\Repository\QuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestRepository::class)]
class Quest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $questText = null;

    #[ORM\Column]
    private ?int $dabloonReward = null;

    #[ORM\Column]
    private ?bool $isCompleted = null;

    /**
     * @var Collection<int, Option>
     */
    #[ORM\OneToMany(targetEntity: Option::class, mappedBy: 'quests')]
    private Collection $options;

    /**
     * @var Collection<int, AcceptedQuest>
     */
    #[ORM\OneToMany(targetEntity: AcceptedQuest::class, mappedBy: 'quest')]
    private Collection $acceptedQuests;

    #[ORM\ManyToOne(inversedBy: 'quests')]
    private ?Item $rewardedItem = null;

    #[ORM\Column]
    private ?bool $singleCompletion = null;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->acceptedQuests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestText(): ?string
    {
        return $this->questText;
    }

    public function setQuestText(string $questText): static
    {
        $this->questText = $questText;

        return $this;
    }

    public function getDabloonReward(): ?int
    {
        return $this->dabloonReward;
    }

    public function setDabloonReward(int $dabloonReward): static
    {
        $this->dabloonReward = $dabloonReward;

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

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
            $option->setQuests($this);
        }

        return $this;
    }

    public function removeOption(Option $option): static
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getQuests() === $this) {
                $option->setQuests(null);
            }
        }

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
            $acceptedQuest->setQuest($this);
        }

        return $this;
    }

    public function removeAcceptedQuest(AcceptedQuest $acceptedQuest): static
    {
        if ($this->acceptedQuests->removeElement($acceptedQuest)) {
            // set the owning side to null (unless already changed)
            if ($acceptedQuest->getQuest() === $this) {
                $acceptedQuest->setQuest(null);
            }
        }

        return $this;
    }

    public function getRewardedItem(): ?Item
    {
        return $this->rewardedItem;
    }

    public function setRewardedItem(?Item $rewardedItem): static
    {
        $this->rewardedItem = $rewardedItem;

        return $this;
    }

    public function isSingleCompletion(): ?bool
    {
        return $this->singleCompletion;
    }

    public function setSingleCompletion(bool $singleCompletion): static
    {
        $this->singleCompletion = $singleCompletion;

        return $this;
    }
}
