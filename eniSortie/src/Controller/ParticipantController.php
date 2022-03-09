<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/updateParticipant/{id}", name="update_participant")
     */
    public function modifier(Participant $p, Request $req, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ParticipantType::class, $p);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em->flush();
            return $this->redirectToRoute('participantList');
        }

        return $this->render('main/updateParticipant.html.twig',
         [ 'formulaire'=> $form->createView()]);
    }

    /**
     * @Route("/participantList", name="participantProfile")
     */
    public function readProfileList(ParticipantRepository $repo): Response
    {
        $participant = $repo->findAll();
        return $this->render('participant/participantList.html.twig', [
            'participants' => $participant,
        ]);
    }


  
}
