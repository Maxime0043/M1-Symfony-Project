<?php

namespace App\DataFixtures;

use App\Entity\Climber;
use App\Entity\Level;
use App\Repository\LevelRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClimberFixtures extends Fixture implements OrderedFixtureInterface
{
    function __construct(private LevelRepository $levelRepository)
    {
    }

    public function getOrder(): array
    {
        return [
            Level::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $roles = $this->levelRepository->findAll();
        $role = $roles[array_rand($roles)];



        $climber = new Climber;
        $climber
            ->setLastname("Lee")
            ->setFirstname("Grimpeur")
            ->setEmail("leegrimpeur@test.com")
            ->setPassword('$2y$13$ZLZC/JIEere8FvxVJfkXZOy4Yj4JUcIQG1LhVNYQlJuoSsF5QJvCG') //lamachine
            ->setPoints(30);

        $climber->setRoles(
            $role

        );


        $manager->persist($climber);

        /*$roles = $this->levelRepository->findAll();
        $roles = $roles[array_rand($roles)];

        $climber = new Climber;
        $climber
            ->setLastname("Paul")
            ->setFirstname("Jean")
            ->setEmail("jeanpaul@test.com")
            ->setPassword('$2y$13$ZLZC/JIEere8FvxVJfkXZOy4Yj4JUcIQG1LhVNYQlJuoSsF5QJvCG') //lamachine
            ->addRole($roles)
            ->setPoints(0);

        $manager->persist($climber);

        $roles = $this->levelRepository->findAll();
        $roles = $roles[array_rand($roles)];

        $climber = new Climber;
        $climber
            ->setLastname("George")
            ->setFirstname("Martin")
            ->setEmail("martingeorge@test.com")
            ->setPassword('$2y$10$wyVV2ExjB8EcdJ6Yac2EJOKPQ1sqFP5AU5tift/XtDYk7EW8yYDye4') //lamachine
            ->addRole($roles)
            ->setPoints(15);

        $manager->persist($climber);*/

        $manager->flush();
    }
}
