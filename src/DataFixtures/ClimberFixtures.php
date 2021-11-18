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
            ->setPassword('$2y$13$ZLZC/JIEere8FvxVJfkXZOy4Yj4JUcIQG1LhVNYQlJuoSsF5QJvCG') //lamachine
            ->setRoles(['ROLE_USER'])
            ->setPoints(30);

        $manager->persist($climber);

        $climber = new Climber;
        $climber
            ->setLastname("Paul")
            ->setFirstname("Jean")
            ->setEmail("jeanpaul@test.com")
            ->setPassword('$2y$13$ZLZC/JIEere8FvxVJfkXZOy4Yj4JUcIQG1LhVNYQlJuoSsF5QJvCG') //lamachine
            ->setRoles(['ROLE_USER'])
            ->setPoints(0);

        $manager->persist($climber);

        $climber = new Climber;
        $climber
            ->setLastname("George")
            ->setFirstname("Martin")
            ->setEmail("martingeorge@test.com")
            ->setPassword('$2y$10$wyVV2ExjB8EcdJ6Yac2EJOKPQ1sqFP5AU5tift/XtDYk7EW8yYDye4') //lamachine
            ->setRoles(['ROLE_USER'])
            ->setPoints(15);

        $manager->persist($climber);

        $manager->flush();
    }
}
