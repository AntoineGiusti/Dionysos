<?php

namespace App\Service;

use App\Repository\ActivityRepository;
use App\Repository\StatusRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

Class StatusChange
{

    private $activityRepository;
    private $statusRepository;
    private $eMI;

    public function __construct(ActivityRepository $activityRepository, StatusRepository $statusRepository, EntityManagerInterface $eMI)
    {
            $this->activityRepository = $activityRepository;
            $this->statusRepository = $statusRepository;
            $this->eMI = $eMI;

    }

    public function chooseStatus ()

    {      
         date_default_timezone_set('Europe/Paris');
            // récup date du jour
            $thisDay = new DateTime();
            // récup liste d'activités
            $activityList = $this->activityRepository->findAll();

        foreach ($activityList as $activity)

            $startDate = $activity->getStartDate();
            $registrationDeadLine = $activity->getRegistrationDeadline();
            $activityDuration = $activity->getActivityDuration();
            $nbRegistration = $activity->getNbRegistration();
    }


















}