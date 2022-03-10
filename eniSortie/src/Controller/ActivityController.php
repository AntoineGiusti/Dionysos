<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManager;
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
     * @Route("/new", name="new_activity", methods={"GET","POST"})
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
     * @Route("/{id}", name="app_activity_show", methods={"GET"})
     */
    public function show(Activity $activity): Response
    {
        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_activity_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Activity $activity, ActivityRepository $activityRepository): Response
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
    public function remove(Activity $activity, EntityManagerInterface $em): Response
    {
        // dd($activity);
        $em->remove($activity);        
        $em->flush();

        return $this->redirectToRoute('activity/_delete_form.html.twig');
    }
    
    
}
