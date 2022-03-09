<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    // /**
    //  * @Route("/", name="home")
    //  */
    // public function home(): Response
    // {
    //     return $this->render('Security/home.html.twig',  [
    //          'titre' => 'home page',
    //     ]);
    // }

     /**
     * @Route("/", name="home")
     */
    public function research(): Response
    {
        
        return $this->render('principal/research.html.twig',  [
             'titre' => 'research page',
        ]);
    }
}
