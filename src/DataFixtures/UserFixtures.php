<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@TPOTDR.com');
        $user->setPassword('$2y$13$02JQqn5emWqiI7c7a1g7yeFZi1qaaTFfH1oPOXdQkuaiDYEH8RnTS');
        $user->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $manager->persist($user);

        $user->setUsername('moderator');
        $user->setEmail('moderator@TPOTDR.com');
        $user->setPassword('$2y$13$iLnXw0.o8Q./IuyDkaEDYe4FEmDsehwL/osphnDOZhNMJlbQOQ3yS');
        $user->setRoles(["ROLE_USER", "ROLE_MODERATOR"]);
        $manager->persist($user);

        $user->setUsername('test user');
        $user->setEmail('test@TPOTDR.com');
        $user->setPassword('$2y$13$rn7fOjy6A6yAvzsmWHe/ee/TrIRjVhk6a96fP5n6OiFgtGMWDWk/S');
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $manager->flush();
    }
}
