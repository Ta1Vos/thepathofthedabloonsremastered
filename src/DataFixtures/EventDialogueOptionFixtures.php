<?php

namespace App\DataFixtures;

use App\Entity\Dialogue;
use App\Entity\Event;
use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventDialogueOptionFixtures extends Fixture implements OrderedFixtureInterface
{
    //These are 3 entities getting edited in 1 fixture due to the fact that they have a ManyToMany relationship.
    public function load(ObjectManager $manager): void
    {
        $dialogue = new Dialogue();
        $dialogue->setName('traveler-dabloon2');
        $dialogue->setDialogueText("Hello there dear traveler! How fortunate we cross eachother's path! Here are 2 dabloons as a gift! Lets hope we will meet again sometime!");

        $event = new Event();
        $event->setName('traveler1-dabloon2');
        $event->setEventText("You've received 2 dabloons!");

        $option = new Option();
        $option->setName('continue');

        $event->addDialogue($dialogue);
        $event->addOption($option);

        $manager->persist($dialogue);
        $manager->persist($event);
        $manager->persist($option);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1; // This will be loaded first
    }
}
