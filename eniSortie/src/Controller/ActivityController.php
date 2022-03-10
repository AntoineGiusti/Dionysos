<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use App\Repository\CampusRepository;
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
    public function remove(int $id , ActivityRepository $activityRepository, EntityManagerInterface $em): Response
    {
         
        //dump($id);
        $activity = $activityRepository->find($id);
       
       
        if($activity){
            $em->remove($activity);        
            $em->flush();
        }

        return $this->redirectToRoute('home');
   
     }
    
    
    
}
