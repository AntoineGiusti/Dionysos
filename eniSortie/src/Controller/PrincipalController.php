<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Activity;
use App\Entity\Status;
use App\Entity\Campus;
use App\Form\ActivityType;
use App\Form\FilterSearchType;
use App\Form\model\FilterSearch;
use App\Form\SearchFormType;
use App\Repository\ActivityRepository;
use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use App\Repository\StatusRepository;
use App\Service\ActivityServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(ActivityServices $activityServices, ActivityRepository $activityRepository, Request $request): Response
    {
        // Je vais récupérer l'ensemble des activités
        //La méthode findSearch() qui peremet de récupérer les produits liés à une recherche
//        $activityServices->resetStatus();
        $data=new SearchData();
        //Définir page avec 1 par défaut
        $data->page=$request->get('page', 1);
        $form= $this->createForm(SearchFormType::class, $data);
        $form->handleRequest($request);

        $activities = $activityRepository->findSearch($data);
        return $this->render('index.html.twig',[
            'activities'=> $activities,
            'form'=>$form->createView()
    ]);
    }
}
