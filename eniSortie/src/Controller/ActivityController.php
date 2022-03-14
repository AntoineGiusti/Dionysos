<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Participant;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use App\Repository\CampusRepository;
use App\Repository\ParticipantRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{

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

    // /**
    //  * @Route("/", name="home")
    //  */
    // public function show(CampusRepository $campusRepository, ActivityRepository $activityRepository): Response
    // {
    //     $activityList = $activityRepository->findAll();
    //     $campus = $campusRepository->findAll();

    //     $createSearchType = new ModelSearchType();
    //     $form = $this->createForm(EventSearchType::class, $createSearchType);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted()&& $form->isValid()){
    //         $data = $form->getData();
    //         $user = $this->getUser();
    //         $activityList = $activityRepository->searchByFilter($data, $user);

    //     }
        
    //     return $this->render('home',[
    //         'activity' => $activityList,
    //         'campus'=>$campus,
    //         'formulaire' => $form->createView(),
            
    //     ]);

    // }

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
    public function cancel(Request $request, Activity $activity, StatusRepository $statusRepository, EntityManagerInterface $em): Response
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

        return $this->render('activity/_delete_form.html.twig',[
            'activity' => $activity                 
         ]);
     }

    //   /**
    //  * @Route("/home", name="filtre_activity")
    //  */
    //  public function researchByStatusId(ActivityRepository $activityRepository, StatusRepository $statusRepository): Response
    //  {
    //     //  $activity = $activityRepository->findOneByStatus('8');
    //     $activity = $activityRepository->findBy(array('status'=>$statusRepository->find('8')));
    //     // dd($activity);
        
 
    //      return $this->render('research.html.twig');
    
    //   }
    
   


    

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
