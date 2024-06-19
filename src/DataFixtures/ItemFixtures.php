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
        $uncommon = $manager->getRepository(Rarity::class)->findOneBy(['name' => 'Uncommon']);
        $rare = $manager->getRepository(Rarity::class)->findOneBy(['name' => 'Rare']);
        $unique = $manager->getRepository(Rarity::class)->findOneBy(['name' => 'Unique']);
        $legendary = $manager->getRepository(Rarity::class)->findOneBy(['name' => 'Legendary']);
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
        $item->setDescription("Heal {$heal10->getEffectValueSeverity()} hp. Yummy!");
        $manager->persist($item);

        $item = new Item();
        $item->setName('Backpack');
        $item->setPrice(25);
        $item->setIsWeapon(false);
//        $item->setDefeatChance(30);
        $item->setRarity($uncommon);
//        $item->addEffect();
        $item->setDescription("Increase inventory space!");
        $manager->persist($item);

        $item = new Item();
        $item->setName('Camping Pack');
        $item->setPrice(50);
        $item->setIsWeapon(false);
//        $item->setDefeatChance(30);
        $item->setRarity($rare);
//        $item->addEffect();
        $item->setDescription("More inventory space!");
        $manager->persist($item);

        $item = new Item();
        $item->setName('Dagger');
        $item->setPrice(2);
        $item->setIsWeapon(true);
        $item->setDefeatChance(70);
        $item->setRarity($unique);
//        $item->addEffect($heal10);
        $item->setDescription("Use to fend off thieves. Has multiple uses. Has a chance to make thieves drop dabloons or items. Learn them a lesson!");
        $manager->persist($item);

        $item = new Item();
        $item->setName('Dabloon Knife');
        $item->setPrice(500);
        $item->setIsWeapon(true);
        $item->setDefeatChance(100);
        $item->setRarity($legendary);
//        $item->addEffect($heal10);
        $item->setDescription("Attract thieves and fend em away at the same time. Seriously? Did you really have to buy this just so you can flex with it? Bruh...");
        $manager->persist($item);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
