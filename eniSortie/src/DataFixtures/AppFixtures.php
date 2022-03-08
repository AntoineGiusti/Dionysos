<?php

namespace App\DataFixtures;


use App\Entity\Participant;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        //On créé 15 participants avec noms et prénoms aléatoires en français"
        $participants=Array();
            for($i=0; $i<15;$i++) {
                $participants[$i] = new Participant();
                $participants[$i]->setEmail($faker->safeEmail);
                $participants[$i]->setLastName($faker->lastName);
                $participants[$i]->setFirstName($faker->firstName);
                //Modification de la BDD pour avoir des numéros >10 car le faker propose des num>10
                $participants[$i]->setPhoneNumber($faker->phoneNumber);
                $participants[$i]->setPassword($faker->password);
                $participants[$i]->setIsActive($faker->randomDigitNotNull);

                $manager->persist($participants[$i]);
            }

        $location=Array();
            for($i=0; $i<15;$i++) {
                $locations[$i] = new Location();
                $locations[$i] -> setName($faker->word);
                $locations[$i] -> setStreet($faker->address);
                $locations[$i] -> setLat($faker->latitude);
                $locations[$i] -> setLng($faker->longitude);

                $manager->persist($locations[$i]);
            }

        $manager->flush();
    }
}
