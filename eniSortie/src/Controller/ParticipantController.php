<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repository\ActivityRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ParticipantController extends AbstractController
{
    /**
     * @Route("/updateParticipant", name="update_participant")
     */
    public function modifier(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        /**
         * @var Participant $participant
         */
       // $participant = new Participant();
        $participant= $this->getUser();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
         {

            
            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo')->getData();
           // return $this->redirectToRoute('participantList');
           
            if ($photoFile) 
            {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

               
                try
                {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) 
                    {
                    }
                    $participant->setPhotoFilename($newFilename);
                    $em->persist($participant);
            }
            $em->flush();
            return $this->redirectToRoute('participantList');
               
        }
            return $this->renderForm('participant/updateParticipant.html.twig', [
                'formulaire' => $form,
                ]);
        
    }

    

    /**
     * @Route("/participantList", name="participantList")
     */
    public function readProfileList(ParticipantRepository $repo): Response
    {
        $participant = $repo->findAll();
        return $this->render('participant/participantList.html.twig', [
            'participants' => $participant,
        ]);
    }

    



 }
