<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Repository\StatusRepository;
use App\Form\model\FilterSearch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{


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

}
