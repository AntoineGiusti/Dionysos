<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="time")
     */
    private $activityDuration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDeadline;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbRegistration;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     */
    private $activityDescription;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getActivityDuration(): ?\DateTimeInterface
    {
        return $this->activityDuration;
    }

    public function setActivityDuration(\DateTimeInterface $activityDuration): self
    {
        $this->activityDuration = $activityDuration;

        return $this;
    }

    public function getRegistrationDeadline(): ?\DateTimeInterface
    {
        return $this->registrationDeadline;
    }

    public function setRegistrationDeadline(\DateTimeInterface $registrationDeadline): self
    {
        $this->registrationDeadline = $registrationDeadline;

        return $this;
    }

    public function getNbRegistration(): ?int
    {
        return $this->nbRegistration;
    }

    public function setNbRegistration(?int $nbRegistration): self
    {
        $this->nbRegistration = $nbRegistration;

        return $this;
    }

    public function getActivityDescription(): ?string
    {
        return $this->activityDescription;
    }

    public function setActivityDescription(?string $activityDescription): self
    {
        $this->activityDescription = $activityDescription;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
