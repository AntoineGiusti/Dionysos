<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Participant;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repository\ActivityRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function modifier(Request $request, SluggerInterface $slugger, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        /**
         * @var Participant $participant
         */
        $participant= $this->getUser();

        $form = $this->createForm(ParticipantType::class, $this->getUser());
        $form->handleRequest($request);
        $password=$form->get('password')->getData();

//        dd($form->isSubmitted());
        if ($form->isSubmitted() && $form->isValid())

         {

            /** @var UploadedFile $photoFile */
             //Upload de l'image
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) 
            {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                //Déplace le fichier dans le dossier upload
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

            if($password){
                //Hacher le mot de passe, le set et le persist
                $hashedPassword =$passwordHasher->hashPassword(
                    $participant,
                    $password,
                );
                $participant->setPassword($hashedPassword);
                $em->persist($participant);

            }

            $em->flush();
            return $this->redirectToRoute('home');
               
        }
            return $this->renderForm('participant/updateParticipant.html.twig', [
                'formulaire' => $form,
                'participant' => $participant,
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

    /**
     * @Route("/showDetailParticipant/{id}" , name="showDetailParticipant")
     */
    public function showDetailParticipant(Participant $participant, ParticipantRepository $repo): Response
    {
    return $this->render('participant/showDetailParticipant.html.twig', [
        'participant' => $participant
        
        
    ]);


 }

    /**
     *  @Route("/{id}", name="app_isRegeisted")
     */

    public function isRegisted($id, Request $request, ActivityRepository $activityRepository,EntityManagerInterface $em)
    {
        $activity = $activityRepository->find($id);
        //dd($activity);
        $activity->addParticipant($this->getUser());
        $em->persist($activity);
        $em ->flush();
    
        return $this->redirectToRoute('home');
    }
}