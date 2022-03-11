<?php

namespace App\DataFixtures;

use DateInterval;
use App\Entity\Activity;
use App\Entity\Town;
use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Location;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
//AJOUT ROXANE POUR HASHER LES MDP//////////////////////////////////////////////
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
////////////////////////////////////////////////////////////////////////////////

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

        //Ici seulement pour tester la BDD
        //Le status dépend des heures de début et de fin d'inscription, d'activités etc.
        //Et du nb d'utilisateurs.
        $statusName = ['Créée','Ouverte','Activité en cours','Cloturée','Passée','Annulée','Historisée'];
        $statuses = [];
        foreach ($statusName as $name) {
            $status = new Status();
            $status->setWording($name);
            $manager->persist($status);
            $statuses[] = $status;
        }

        $faker = Faker\Factory::create('fr_FR');
        $faker->seed(1337);
        //On créé 15 participants avec noms et prénoms aléatoires en français"
        $participants = array();
        for ($i = 0; $i < 15; $i++) {
            $participants[$i] = new Participant();
            $participants[$i]->setEmail($faker->safeEmail);
            $participants[$i]->setLastName($faker->lastName);
            $participants[$i]->setFirstName($faker->firstName);
            //Modification de la BDD pour avoir des numéros >10 car le faker propose des num>10
            $participants[$i]->setPhoneNumber($faker->phoneNumber);

            //WRONG !!!! IL FAUT HASHER LES MDP AVANT
            //VOIR PLUS HAUT private UserPasswordHasherInterface $hasher;
            // $participants[$i]->setPassword($faker->password);
            //  $participants[$i]->setPassword('mdp');

            $password = $this->hasher->hashPassword($participants[$i], 'pass_1234');
            $participants[$i]->setPassword($password);


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



        $locations = array();
        for ($i = 0; $i < 15; $i++) {
            $locations[$i] = new Location();
            $locations[$i]->setName($faker->word);
            $locations[$i]->setStreet($faker->streetAddress);
            $locations[$i]->setTown($towns[mt_rand(0, 9)]);
            $locations[$i]->setLat($faker->latitude);
            $locations[$i]->setLng($faker->longitude);

            $manager->persist($locations[$i]);
        }



        $towns = [
            'Rennes', 'Nantes', 'Quimper', 'Paris', 'Toulouse',
            'Lorient', 'Lyon', 'Tour', 'Angers', 'Lille',
            'Marseille', 'Rouen', 'Poitiers', 'Limoges', 'Dijon',
            'Valence', 'Bayonne', 'Brest', 'Dunkerque', 'Montpellier'
        ];
        $ActivityNamePart1 = ['Sortie à ', 'Allons à ', 'Visite de ', 'Fête à ', 'Let\'s go to '];
        $ActivityDescriptionPart1 = ['Partons tous à pour le week-end à ', 'Allons nous amuser à ', 'Rendez-vous à l\'école puis on part tous en bus pour aller à ', 'Fête à '];
        for ($i = 0; $i < count($towns); $i++) {
            $activity = new Activity();
            $activity->setName($ActivityNamePart1[mt_rand(0, count($ActivityNamePart1) - 1)] . $towns[$i]);
            $activity->setActivityDescription($ActivityDescriptionPart1[mt_rand(0, count($ActivityDescriptionPart1) - 1)] . $towns[$i]);
            $activity->setCampus($campuses[mt_rand(0, 2)]);
            $activity->setOrganizer($participants[mt_rand(0, 14)]);
            $minutes = strval(mt_rand(5, 120)) . ' minutes';
            $activity->setActivityDuration($faker->randomNumber(3, false));
            $activity->setNbRegistration(mt_rand(2, 25));
            $date1 = $faker->dateTimeBetween('-40days', '+40days');

            $dateString = date_format($date1, 'Y-m-d');
            //$date2 = $faker->dateTimeBetween('-40days', '+40days');
            $date2 = $faker->dateTimeInInterval($dateString, '-7days');
            if ($date1 > $date2) {
                $activity->setStartDate($date1);
                $activity->setRegistrationDeadline($date2);
            } else {
                $activity->setStartDate($date2);
                $activity->setRegistrationDeadline($date1);
            }
            $activity->setLocation($locations[mt_rand(0, 14)]);
            // $activity->setLocation($this->mapService->geocodeAddress('mairie', $towns[$i]));


            $activity->setStatus($statuses[mt_rand(0, 6)]);
            $manager->persist($activity);
        }



        $manager->flush();
    }
}
