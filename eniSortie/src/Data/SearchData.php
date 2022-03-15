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
     * @var Campus
     */

    public $campus;

    //Est l'organisateur ou non ?
    /**
     * @var
     */

    public $isOrganizer;

    //Est inscrit
    /**
     * @var
     */

    public $isRegistered;


    //N'est pas inscrit
    /**
     * @var
     */
    public $isNotRegistered;


    /**
     * @var
     */
    public $date1;

    /**
     * @var
     */
    public $date2;

    /**
     * @var
     */
    public $passedActivity;

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return string
     */
    public function getQ(): string
    {
        return $this->q;
    }

    /**
     * @param string $q
     */
    public function setQ(string $q): void
    {
        $this->q = $q;
    }

    /**
     * @return Campus
     */
    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus $campus
     */
    public function setCampuses(?Campus $campus): void
    {
        $this->campus = $campus;
    }

    /**
     * @return mixed
     */
    public function getIsOrganizer()
    {
        return $this->isOrganizer;
    }

    /**
     * @param mixed $isOrganizer
     */
    public function setIsOrganizer($isOrganizer): void
    {
        $this->isOrganizer = $isOrganizer;
    }

    /**
     * @return mixed
     */
    public function getIsRegistered()
    {
        return $this->isRegistered;
    }

    /**
     * @param mixed $isRegistered
     */
    public function setIsRegistered($isRegistered): void
    {
        $this->isRegistered = $isRegistered;
    }

    /**
     * @return mixed
     */
    public function getIsNotRegistered()
    {
        return $this->isNotRegistered;
    }

    /**
     * @param mixed $isNotRegistered
     */
    public function setIsNotRegistered($isNotRegistered): void
    {
        $this->isNotRegistered = $isNotRegistered;
    }

    /**
     * @return mixed
     */
    public function getDate1()
    {
        return $this->date1;
    }

    /**
     * @param mixed $date1
     */
    public function setDate1($date1): void
    {
        $this->date1 = $date1;
    }

    /**
     * @return mixed
     */
    public function getDate2()
    {
        return $this->date2;
    }

    /**
     * @param mixed $date2
     */
    public function setDate2($date2): void
    {
        $this->date2 = $date2;
    }

    /**
     * @return mixed
     */
    public function getPassedActivity()
    {
        return $this->passedActivity;
    }

    /**
     * @param mixed $passedActivity
     */
    public function setPassedActivity($passedActivity): void
    {
        $this->passedActivity = $passedActivity;
    }


}