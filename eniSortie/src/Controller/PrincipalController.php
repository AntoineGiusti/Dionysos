<?php

namespace App\Controller;

use App\Form\model\FilterSearch;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    

    /**
     * @Route("/research", name="filter_status")
     */
     public function filterByStatus(ActivityRepository $activityRepository , StatusRepository $statusRepository): Response
     {
         $status= $statusRepository->findOneBy(['wording'=>'Créée']);
        // $activity = $activityRepository->findBy(array('status'=>$statusRepository->findOneBy('Créée')));

         return $this->render('principal/research.html.twig', [
             'status' => $activityRepository->findAll(),
             'titre'=>'Liste des activités',
         ]);
     }

    //  /**
    //  * @Route("/", name="home")
    //  */
    // public function registration(Activity $activity, ActivityRepository $activityRepository, EntityManagerInterface $em): Response
    // {
    //    $activity;
    //    $isRegisted= $activity->getNbRegistration();
    //    if($isRegisted)
    //    {
    //        $em->
    //    }


    //     return $this->render('principal/research.html.twig', [
    //         'activities' => $activityRepository->findAll(),
    //         'titre'=>'Liste des activités',
    //     ]);
    // }


}
