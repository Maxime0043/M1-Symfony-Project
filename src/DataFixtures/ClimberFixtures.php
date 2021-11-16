<?php

namespace App\DataFixtures;

use App\Entity\Climber;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClimberFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $climber = new Climber;
        
        $climber
            ->setLastname("Lee")
            ->setFirstname("Grimpeur")
            ->setEmail("leegrimpeur@test.com")
            ->setPassword('$2y$10$wyVV2ExjB8EcdJ6Yac2EJOKPQ1sqFP5AU5tift/XtDYk7EW8yYDye4') //lamachine
            ->setPoints(100)
        ;

        $manager->persist($climber);

        $manager->flush();
    }
}
