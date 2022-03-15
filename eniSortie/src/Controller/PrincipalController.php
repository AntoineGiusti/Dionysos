<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Form\model\FilterSearch;
use App\Repository\ActivityRepository;
use App\Repository\StatusRepository;
=======
use App\Repository\ActivityRepository;
use App\Repository\StatusRepository;
use App\Form\model\FilterSearch;
>>>>>>> a0958f170e6865b99ce516ca344ca221518997a8
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
<<<<<<< HEAD
    

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
=======


//    /**
//     * @Route("/research", name="filter_status")
//     */
//    public function filterByStatus(ActivityRepository $activityRepository , StatusRepository $statusRepository): Response
//    {
//        $status= $statusRepository->findOneBy(['wording']);
//
//        return $this->render('principal/research.html.twig', [
//            'status' => $activityRepository->findAll(),
//            'titre'=>'Liste des activités',
//        ]);
//    }
//
//    /**
//     * @Route("/research", name="filter_status")
//     */
//     public function filterByStatus(ActivityRepository $activityRepository , StatusRepository $statusRepository): Response
//     {
//         $status= $statusRepository->findOneBy(['wording'=>'Créée']);
//        // $activity = $activityRepository->findBy(array('status'=>$statusRepository->findOneBy('Créée')));
//
//         return $this->render('principal/research.html.twig', [
//             'status' => $activityRepository->findAll(),
//             'titre'=>'Liste des activités',
//         ]);
//     }
//
>>>>>>> a0958f170e6865b99ce516ca344ca221518997a8

}
