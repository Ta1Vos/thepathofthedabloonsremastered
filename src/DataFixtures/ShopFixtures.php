<?php

namespace App\DataFixtures;

use App\Entity\Rarity;
use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $common = $manager->getRepository(Rarity::class)->findOneBy(['name' => 'Common']);

        $shop = new Shop();
        $shop->setName('Common Shop');
        $shop->setAdditionalLuck(0);
        $shop->setAdditionalPrice(0);
        $shop->setItemAmount(2);
        $shop->setRarity($common);
        $manager->persist($shop);

        $manager->flush();
    }
    public function getOrder(): int
    {
        return 9;
    }

}
