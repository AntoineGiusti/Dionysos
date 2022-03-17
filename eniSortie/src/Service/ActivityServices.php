<?php

namespace App\Service;

use App\Entity\Activity;
use App\Entity\Status;
use App\Repository\ActivityRepository;
use App\Repository\StatusRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ActivityServices

{
   
    private ActivityRepository $activityRepository;
    private StatusRepository $statusRepository;
    private EntityManagerInterface $em;

public function __construct(ActivityRepository $activityRepository, StatusRepository $statusRepository, EntityManagerInterface $em)
{
   
    $this->activityRepository = $activityRepository;
    $this->statusRepository= $statusRepository;
    $this->em = $em;
    
}

//        //fonction de service qui permet de mettre un status sur une activity en fonction des temps
//    public function resetStatus()
//    {
//
//
//        $activity = $this->activityRepository->findAll();
//        $status = $this->statusRepository->findAll();
//        foreach($activity as $a){
//           $now = new \DateTime();
//           $now2 = clone $now;
//           $histoDate = $now2->modify('-1 month');
//
//           if($a->getStartDate()<$histoDate)
//           {
//               $a->setStatus($status[4]);
//               $this->em->persist($a);
//
//           }elseif($a->getStatus()->getWording() != 'Passée'
//           && $a->getStartDate() > $histoDate
//           && date_add(clone $a->getStartDate(), date_interval_create_from_date_string($a->getActivityDuration().' minutes')) < $now)
//           {
//               $a->setStatus($status[3]);
//               $this->em->persist($a);
//
//           }elseif($a->getStatus()->getWording() != 'Cloturée'
//           && $a->getRegistrationDeadline() < $now
//           && $a->getStartDate()> $now)
//           {
//               $a->setStatus($status[2]);
//               $this->em->persist($a);
//           }elseif($a->getStatus()->getWording() != 'Activité en cours'
//           && $a->getStatus()->getWording() != 'Annulée'
//           && date_add(clone $a->getStartDate(),date_interval_create_from_date_string($a->getActivityDuration().' minutes'))> $now)
//           {
//               $a->setStatus($status[1]);
//               $this->em->persist($a);
//           }
//
//        } $this->em->flush();
//
//    }


}