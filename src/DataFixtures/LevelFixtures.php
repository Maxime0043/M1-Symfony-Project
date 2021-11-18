<?php

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LevelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $level = new Level;
        $level
            ->setName("Bronze")
            ->setPointsNeeded(0);
        $manager->persist($level);

        $level = new Level;
        $level
            ->setName("Argent")
            ->setPointsNeeded(10);
        $manager->persist($level);

        $level = new Level;
        $level
            ->setName("Or")
            ->setPointsNeeded(30);
        $manager->persist($level);

        $manager->flush();
    }
}
