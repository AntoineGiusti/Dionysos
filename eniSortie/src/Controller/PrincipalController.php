<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\model\FilterSearch;
use App\Repository\ActivityRepository;
use App\Repository\StatusRepository;
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
        
        $activity = new FilterSearch();

        //fonction de filtre a terminer !


        return $this->render('principal/research.html.twig', [
            'activities' => $activityRepository->findAll(),
            'titre'=>'Liste des activités',
        ]);
    }




    /**
     * @Route("/research", name="filter_status")
     */
    // public function filterByStatus(ActivityRepository $activityRepository , StatusRepository $statusRepository): Response
    // {
    //     $status= $statusRepository->findOneBy(['wording'=>'Créée']);
    //    // $activity = $activityRepository->findBy(array('status'=>$statusRepository->findOneBy('Créée')));
        
    //     return $this->render('principal/research.html.twig', [
    //         'status' => $activityRepository->findAll(),
    //         'titre'=>'Liste des activités',
    //     ]);
    // }

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
