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

        //Détermine l'organisteur du site (User) et le campus organisateur (campus du User)
        $organizer = $this->getUser();
        $activity->setOrganizer($organizer);
        $campus= $organizer->getCampus();
        $activity->setCampus($campus);
        ///////////////////////////////////////


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();
            $this->addFlash('success', 'Votre activité a été crée avec succès !');
            return $this->redirectToRoute('home');
        }

        return $this->render('activity/new.html.twig', [
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
            $this->addFlash('success', 'Votre activité a été modifiée avec succès !');
            return $this->redirectToRoute('app_activity_edit', ['id' => $activity->getId()] );
        }

        return $this->render('activity/edit.html.twig', [
            //'activity' => $activity,
            'activity'=>$form->createView()
        ]);
    }

    /**
     * @Route("/cancel/{id}", name="app_activity_cancel")
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
            $this->addFlash('success', 'Votre activité a été annulée avec succès !');
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
