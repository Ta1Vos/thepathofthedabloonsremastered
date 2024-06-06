<?php

namespace App\DataFixtures;

use App\Entity\World;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorldFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $world = new World();
        $world->setName('The Forest');
        $world->setDistanceLimit(0);
        $manager->persist($world);

        $world = new World();
        $world->setName('The Village');
        $world->setDistanceLimit(12);
        $manager->persist($world);

        $world = new World();
        $world->setName('The Dark Forest');
        $world->setDistanceLimit(12);
        $manager->persist($world);

        $world = new World();
        $world->setName('Rolling Hills');
        $world->setDistanceLimit(25);
        $manager->persist($world);

        $world = new World();
        $world->setName('Freezing Taiga');
        $world->setDistanceLimit(35);
        $manager->persist($world);

        $world = new World();
        $world->setName('IceHeart Village');
        $world->setDistanceLimit(40);
        $manager->persist($world);

        $world = new World();
        $world->setName('BlueIce Valley');
        $world->setDistanceLimit(45);
        $manager->persist($world);

        $world = new World();
        $world->setName('Barren Flatlands');
        $world->setDistanceLimit(55);
        $manager->persist($world);

        $world = new World();
        $world->setName('Peaking Mountains');
        $world->setDistanceLimit(75);
        $manager->persist($world);

        $world = new World();
        $world->setName('Traveler\'s Inn.');
        $world->setDistanceLimit(85);
        $manager->persist($world);

        $world = new World();
        $world->setName('Point of No Return');
        $world->setDistanceLimit(85);
        $manager->persist($world);

        $world = new World();
        $world->setName('Ash Hills');
        $world->setDistanceLimit(86);
        $manager->persist($world);

        $world = new World();
        $world->setName('Temple of the Molten Dabloons');
        $world->setDistanceLimit(100);
        $manager->persist($world);

        $manager->flush();
    }
}
