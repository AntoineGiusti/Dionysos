<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('principal/home.html.twig',  [
             'titre' => 'home page',
        ]);
    }

//Afficher la liste des activités pour ensuite faire la recherche
     /**
     * @Route("/research", name="research")
     */
    public function research(ActivityRepository $activityRepository): Response
    {
        return $this->render('principal/research.html.twig', [
            'activities' => $activityRepository->findAll(),
            'titre'=>'Liste des activités',
        ]);
    }
}
