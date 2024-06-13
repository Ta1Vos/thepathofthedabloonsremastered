<?php

namespace App\DataFixtures;

use App\Entity\Rarity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RarityFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $rarity = new Rarity();
        $rarity->setName('Common');
        $rarity->setChanceIn(85);
        $rarity->setPriority(1);
        $manager->persist($rarity);

        $rarity = new Rarity();
        $rarity->setName('Uncommon');
        $rarity->setChanceIn(40);
        $rarity->setPriority(2);
        $manager->persist($rarity);

        $rarity = new Rarity();
        $rarity->setName('Rare');
        $rarity->setChanceIn(15);
        $rarity->setPriority(3);
        $manager->persist($rarity);

        $rarity = new Rarity();
        $rarity->setName('Unique');
        $rarity->setChanceIn(5);
        $rarity->setPriority(4);
        $manager->persist($rarity);

        $rarity = new Rarity();
        $rarity->setName('Legendary');
        $rarity->setChanceIn(2);
        $rarity->setPriority(5);
        $manager->persist($rarity);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1; // This will be loaded first
    }
}
