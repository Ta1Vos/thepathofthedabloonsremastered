<?php

namespace App\DataFixtures;

use App\Entity\Rarity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RarityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $rarity = new Rarity();
        $rarity->setName('Common');
        $rarity->setChanceIn(85);

        $rarity = new Rarity();
        $rarity->setName('Uncommon');
        $rarity->setChanceIn(65);

        $rarity = new Rarity();
        $rarity->setName('Rare');
        $rarity->setChanceIn(75);

        $rarity = new Rarity();
        $rarity->setName('Unique');
        $rarity->setChanceIn(70);

        $rarity = new Rarity();
        $rarity->setName('Legendary');
        $rarity->setChanceIn(100);

        $manager->flush();
    }
}
