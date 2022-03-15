<?php

namespace App\Data;

//un Datamodel qui va représenter les données associées au formulaire de recherche

use App\Entity\Campus;

class SearchData
{

    /**
     * @var int
     */
    public $page =1;


    //propriété publique de search bar
    /**
     * @var string
     */

    public $q = '';


    //Quel campus ?
    /**
     * @var Campus[]
     */

    public $campuses = [];

    //Est l'organisateur ou non ?
    /**
     * @var boolean
     */

    public $isOrganizer;

    //Est inscrit ou non ?
    /**
     * @var boolean
     */

    public $isRegistered;


    /**
     * @var
     */
    public $date1;

    /**
     * @var
     */
    public $date2;



}