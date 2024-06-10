<?php

namespace App\DataFixtures;

use App\Entity\Effect;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EffectFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $effect = new Effect();
        $effect->setName('heal 10hp');
        $effect->setDebuffDuration(1);
        $effect->setDebuffSeverity('10');
        $manager->persist($effect);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2; // This will be loaded first
    }
}
