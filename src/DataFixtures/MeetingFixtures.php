<?php

namespace App\DataFixtures;

use App\Entity\Climber;
use App\Entity\Level;
use App\Entity\Meeting;
use App\Repository\ClimberRepository;
use App\Repository\LevelRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MeetingFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(private LevelRepository $levelRepository, private ClimberRepository $climberRepository)
    {
        
    }

    public function getOrder():array
    {
        return [
            Climber::class,
            Level::class
        ];
    }

    public function load(ObjectManager $manager): void
    {   
        
        $date = new \DateTime('@'.strtotime('now'));
        $dateNextWeek = new \DateTime('@'.strtotime('+1 week'));
        $grimpeurOr = $this->climberRepository->findOneBy(array('email' => 'leegrimpeur@test.com'));
        

        for ($i=0; $i < 8; $i++) { 
            $faker = Faker\Factory::create('fr_FR');
            $meeting = new Meeting;
            $meeting
                ->setTitle($faker->word)
                ->setDescription("Pour les plus courageux")
                ->setDate($date)
                ->setLocation($faker->address)
                ->setLimitClimber($faker->numberBetween(2,25))
                ->setPicture('https://www.autolagon.fr/blog/wp-content/uploads/2019/08/visiter-la-guadeloupe-siroter-cocktail-antilles-1080x675.jpg')
                ->setLevel($this->levelRepository->findOneBy(array('name' => 'Argent')))
                ->setClimber($grimpeurOr);
            $manager->persist($meeting);
        }

        for ($i=0; $i < 8; $i++) { 
            $faker = Faker\Factory::create('fr_FR');
            $meeting = new Meeting;
            $meeting
                ->setTitle($faker->word)
                ->setDescription("Bienvenue au débutant")
                ->setDate($dateNextWeek)
                ->setLocation($faker->address)
                ->setLimitClimber($faker->numberBetween(2,25))
                ->setPicture('https://i1.wp.com/lafabriqueverticale.com/wp-content/uploads/2016/11/escalade-marche-expansion.jpg?fit=720%2C338&ssl=1')
                ->setLevel($this->levelRepository->findOneBy(array('name' => 'Bronze')))
                ->setClimber($grimpeurOr);
            $manager->persist($meeting);
        }
        $manager->flush();
    }
}
