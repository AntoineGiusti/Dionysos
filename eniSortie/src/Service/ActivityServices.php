<?php

namespace App\Service;

use App\Entity\Activity;
use App\Repository\StatusRepository;
use DateTime;

class ActivityServices
{
        //fonction de service qui permet de gerer l'update en fonction de l'etat.

function isUdatable(Activity $activity, $participant)
        // Si l'activity est passée, annulée ou que les inscription sont closes, on ne peut plus la modifier
    {
        $statusPast = in_array($activity->getStatus()->getCode(),['CLOT', 'PAST', 'ANNU']);
        $isNotClose = $activity->getOrganizer() != $participant;
        return !$statusPast && !$isNotClose;

    }
        //fonction de service qui permet de mettre un status sur une activity en fonction des temps
function setStatus(Activity $activity, $status, StatusRepository $statusRepository  )
    {
        // Si les status sont creation ou annulé, le status sera inactif
        if($status === ['code', 'CREA'] || $status === ['code','ANNU']){
            $activity->setStatus($statusRepository->find($status));        
        }else{
            // gestion du fuseau horaire
            date_default_timezone_set('Europe/Paris');

            //variables de gestions des temps selons les dates d'activity:

            // date de debut
            $activityStart = $activity->getStartDate()->getTimestamp();
            //date de fin
            $activityEnd = $activityStart +($activity->getActivityDuration() * 1000 * 60);
            // date de cloture d'inscription
            $closure = $activity->getRegistrationDeadline()->getTimestamp();
            // date de maintenant
            $nowDate =(new DateTime())->getTimestamp();
            
            // si la date de maintenant est sup a la date de fin d'activity, l'activity est passée
            if($activityEnd < $nowDate)
            {
                $activity->setStatus($statusRepository->find(['code', 'PAST']));
            }
            // si la date de maintenant est sup a la date de debut mais inf a la date de fin, l'inscription est cloturée
            else if($activityStart < $nowDate && $activityEnd > $nowDate)
            {
                $activity->setStatus($statusRepository->find(['code', 'CLOT']));
            }
            // si la date de maintenant est sup a la date de cloture des inscription, l'activity est en cours et non rejoignable
            else if($closure < $nowDate)
            {
                $activity->setStatus($statusRepository->find(['code','PROG']));
            }
            // sinon le status est ouvert a l'inscription
            else
            {
                $activity->setStatus($statusRepository->find(['code','OPEN']));
            }

        }
    }


}