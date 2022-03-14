<?php

namespace App\Form\model;

class FilterSearch{

//attibuts de class pout Filtrer les sorties

//campus

private $campus;

//searhbar filtre by motclé

private $searchBar;

//activityName

private $activityName;

//startDate

private $startDate;

//endDate

private $endDate;

//activityOrganizer

private $activityOrganizer;

//registedMeActivity

private $registedMeActivity;

//unregistedMeActivity

private $unregistedMeActivity;

//pastActivity

private $pastActivity;




/**
 * Get the value of campus
 */
public function getCampus()
{
return $this->campus;
}

/**
 * Set the value of campus
 */
public function setCampus($campus): self
{
$this->campus = $campus;

return $this;
}

/**
 * Get the value of searchBar
 */
public function getSearchBar()
{
return $this->searchBar;
}

/**
 * Set the value of searchBar
 */
public function setSearchBar($searchBar): self
{
$this->searchBar = $searchBar;

return $this;
}



/**
 * Get the value of activityName
 */
public function getActivityName()
{
return $this->activityName;
}

/**
 * Set the value of activityName
 */
public function setActivityName($activityName): self
{
$this->activityName = $activityName;

return $this;
}

/**
 * Get the value of startDate
 */
public function getStartDate()
{
return $this->startDate;
}

/**
 * Set the value of startDate
 */
public function setStartDate($startDate): self
{
$this->startDate = $startDate;

return $this;
}

/**
 * Get the value of endDate
 */
public function getEndDate()
{
return $this->endDate;
}

/**
 * Set the value of endDate
 */
public function setEndDate($endDate): self
{
$this->endDate = $endDate;

return $this;
}

/**
 * Get the value of activityOrganizer
 */
public function getActivityOrganizer()
{
return $this->activityOrganizer;
}

/**
 * Set the value of activityOrganizer
 */
public function setActivityOrganizer($activityOrganizer): self
{
$this->activityOrganizer = $activityOrganizer;

return $this;
}

/**
 * Get the value of registedMeActivity
 */
public function getRegistedMeActivity()
{
return $this->registedMeActivity;
}

/**
 * Set the value of registedMeActivity
 */
public function setRegistedMeActivity($registedMeActivity): self
{
$this->registedMeActivity = $registedMeActivity;

return $this;
}

/**
 * Get the value of unregistedMeActivity
 */
public function getUnregistedMeActivity()
{
return $this->unregistedMeActivity;
}

/**
 * Set the value of unregistedMeActivity
 */
public function setUnregistedMeActivity($unregistedMeActivity): self
{
$this->unregistedMeActivity = $unregistedMeActivity;

return $this;
}

/**
 * Get the value of pastActivity
 */
public function getPastActivity()
{
return $this->pastActivity;
}

/**
 * Set the value of pastActivity
 */
public function setPastActivity($pastActivity): self
{
$this->pastActivity = $pastActivity;

return $this;
}


}