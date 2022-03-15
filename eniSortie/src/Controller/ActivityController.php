<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Activity;
use App\Form\ActivityType;
use App\Form\FilterSearchType;
use App\Form\model\FilterSearch;
use App\Form\SearchForm;
use App\Repository\ActivityRepository;
use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{


    /**
     * @Route("/", name="home")
     */
    public function index(CampusRepository $campusRepository, ActivityRepository $activityRepository, Request $request): Response
    {

        // Je vais récupérer l'ensemble des activités
        //La méthode findSearch() qui peremet de récupérer les produits liés à une recherche

        $data=new SearchData();
        //Définir page avec 1 par défaut
        $data->page=$request->get('page', 1);
        $form= $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);


        $activities = $activityRepository->findSearch($data);
        return $this->render('index.html.twig',[
            'activities'=> $activities,
            'form'=>$form->createView()
    ]);
    }

    /**
     * @Route("/new", name="new_activity")
     */
    public function new(Request $request, ActivityRepository $activityRepository): Response
    {
        
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);
        $activity->setOrganizer($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();
           }

        return $this->render('activity/new.html.twig', [
            //'activity' => $activity,
            'activity'=>$form->createView() 
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_activity_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Activity $activity): Response
    {
        $activity ;
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);
        $activity->setOrganizer($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();
           }

        return $this->render('activity/edit.html.twig', [
            //'activity' => $activity,
            'activity'=>$form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_activity_delete")     
     */
    public function cancel(Request $request, Activity $activity, EntityManagerInterface $em): Response
    {
         

        if ($request->get('motif')) {
            $activity->setActivityDescription($request->get('motif'));
            // ligne ci dessous a modifier quand on aura geré les status. codeActivity est une colonne en plus dans la BDD pour ne pas
            //Travailler avec l'ID ou avec le libelle
            // $activity->setStatus($statusRepository->findOneBy(array('codeActivity' => 'ANNU')));
            $em->persist($activity);
            $em->flush();
            return $this->redirectToRoute('home');
           }

        return $this->render('activity/_cancel.html.twig',[
            'activity' => $activity                 
         ]);
     }

       /**
     * @Route("/showDetailActivity/{id}", name="show_detail_activity")     
     */
    public function showDetailActivity( Activity $activity, ActivityRepository $activityRepository, ParticipantRepository $participantRepository): Response
    {
         
        return $this->render('activity/showDetailActivity.html.twig', [
            'activity' => $activity
            
            
        ]);
   
     }

     

     

    
}
