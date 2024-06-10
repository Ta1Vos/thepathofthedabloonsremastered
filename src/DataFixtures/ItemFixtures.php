<?php

namespace App\DataFixtures;

use App\Entity\Effect;
use App\Entity\Item;
use App\Entity\Rarity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $common = $manager->getRepository(Rarity::class)->findOneBy(['name' => 'Common']);
        $heal10 = $manager->getRepository(Effect::class)->findOneBy(['name' => 'heal 10hp']);

         $item = new Item();
         $item->setName('Twig');
         $item->setPrice(5);
         $item->setIsWeapon(true);
         $item->setDefeatChance(30);
         $item->setRarity($common);
//         $item->addEffect(null);
        $item->setDescription("{$item->getDefeatChance()}% chance to fend off enemies. But seriously, it's literally a twig.");
         $manager->persist($item);

        $item = new Item();
        $item->setName('Sandwich');
        $item->setPrice(2);
        $item->setIsWeapon(false);
//        $item->setDefeatChance(30);
        $item->setRarity($common);
        $item->addEffect($heal10);
        $item->setDescription("Heal {$heal10->getDebuffSeverity()} hp. Yummy!");
        $manager->persist($item);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
