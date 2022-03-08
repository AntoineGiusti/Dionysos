<?php

namespace App\DataFixtures;

use App\Entity\Town;
use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $campusName = ['CHARTRES DE BRETAGNE', 'SAINT HERBLAIN', 'LA ROCHE SUR YON'];
        $campuses = [];
        foreach ($campusName as $name) {
            $campus = new Campus();
            $campus->setName($name);
            $manager->persist($campus);
            $campuses[] = $campus;
        }



        //$statusName = ['Créée','Ouverte',''] à adapter en fonction des dates. 

        $faker = Faker\Factory::create('fr_FR');
        //On créé 15 participants avec noms et prénoms aléatoires en français"
        $participants = array();
        for ($i = 0; $i < 15; $i++) {
            $participants[$i] = new Participant();
            $participants[$i]->setEmail($faker->safeEmail);
            $participants[$i]->setLastName($faker->lastName);
            $participants[$i]->setFirstName($faker->firstName);
            //Modification de la BDD pour avoir des numéros >10 car le faker propose des num>10
            $participants[$i]->setPhoneNumber($faker->phoneNumber);
            $participants[$i]->setPassword($faker->password);
            $participants[$i]->setIsActive(true);
            $participants[$i]->setCampus($campuses[mt_rand(0, 2)]);

            $manager->persist($participants[$i]);
        }



        $towns = [];
        for ($i = 0; $i < 10; $i++) {
            $town = new Town();
            $town->setName($faker->city);
            $town->setPostalCode($faker->postcode);
            $manager->persist($town);
            $towns[] = $town;
        }

        $location = array();
        for ($i = 0; $i < 15; $i++) {
            $locations[$i] = new Location();
            $locations[$i]->setName($faker->word);
            $locations[$i]->setStreet($faker->streetAddress);
            $locations[$i]->setTown($towns[mt_rand(0, 9)]);
            $locations[$i]->setLat($faker->latitude);
            $locations[$i]->setLng($faker->longitude);

            $manager->persist($locations[$i]);
        }

        $manager->flush();
    }
}
