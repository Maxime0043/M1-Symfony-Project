<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User;
        $user
            ->setEmail("leegrimpeur@test.com")
            ->setPassword('$2y$13$ZLZC/JIEere8FvxVJfkXZOy4Yj4JUcIQG1LhVNYQlJuoSsF5QJvCG') //lamachine
            ->setRoles(['ROLE_USER'])
        ;

        $manager->persist($user);

        $user = new User;
        $user
            ->setEmail("jeanpaul@test.com")
            ->setPassword('$2y$10$wyVV2ExjB8EcdJ6Yac2EJOKPQ1sqFP5AU5tift/XtDYk7EW8yYDye4') //lamachine
            ->setRoles(['ROLE_USER'])
        ;

        $manager->persist($user);

        $user = new User;
        $user
            ->setEmail("martingeorge@test.com")
            ->setPassword('$2y$10$wyVV2ExjB8EcdJ6Yac2EJOKPQ1sqFP5AU5tift/XtDYk7EW8yYDye4') //lamachine
            ->setRoles(['ROLE_USER'])
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
