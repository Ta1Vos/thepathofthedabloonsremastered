<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
class Shop
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
}
