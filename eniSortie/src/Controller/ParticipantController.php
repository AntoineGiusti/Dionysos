<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ParticipantController extends AbstractController
{
    /**
     * @Route("/updateParticipant", name="update_participant")
     */
    public function modifier( Request $req, EntityManagerInterface $em): Response
    {
        $p = new Participant();
        $form = $this->createForm(ParticipantType::class, $p);
        $form->handleRequest($req);
//          if ($form->isSubmitted()) {
//             $em->flush();
//         return $this->redirectToRoute('participantList');
//        }

        return $this->render('participant/updateParticipant.html.twig',
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
