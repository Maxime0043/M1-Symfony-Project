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
        $role_bronze = $this->levelRepository->findOneBy(array('name' => 'Bronze'));
        $role_argent = $this->levelRepository->findOneBy(array('name' => 'Argent'));
        $role_or = $this->levelRepository->findOneBy(array('name' => 'Or'));

        $climber = new Climber;
        $climber
            ->setLastname("Lee")
            ->setFirstname("Grimpeur")
            ->setEmail("test@test.com")
            ->setPassword('$2y$13$xCoOKMr.yvH8v3mJPKSHKuHx6ovkB8hYtopfVn/msEPuaY8URP6qq') //test
            ->setPoints(30)
            ->setRoles($role_or);

        $manager->persist($climber);

        $climber = new Climber;
        $climber
            ->setLastname("George")
            ->setFirstname("Martin")
            ->setEmail("martingeorge@test.com")
            ->setPassword('$2y$10$wyVV2ExjB8EcdJ6Yac2EJOKPQ1sqFP5AU5tift/XtDYk7EW8yYDye4') //lamachine
            ->setRoles($role_argent)
            ->setPoints(15);

        $manager->persist($climber);

        $climber = new Climber;
        $climber
            ->setLastname("Paul")
            ->setFirstname("Jean")
            ->setEmail("jeanpaul@test.com")
            ->setPassword('$2y$13$ZLZC/JIEere8FvxVJfkXZOy4Yj4JUcIQG1LhVNYQlJuoSsF5QJvCG') //lamachine
            ->setRoles($role_bronze)
            ->setPoints(0);

        $manager->persist($climber);

        $manager->flush();
    }
}
