<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    

//Afficher la liste des activités pour ensuite faire la recherche
     /**
     * @Route("/", name="home")
     */
    public function research(ActivityRepository $activityRepository): Response
    {
        
        return $this->render('principal/research.html.twig', [
            'activities' => $activityRepository->findAll(),
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
