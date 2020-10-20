<?php

namespace App\Entity;

use App\Repository\TournamentEntry2Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TournamentEntry2Repository::class)
 */
class TournamentEntry2
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $traveldistance;

    /**
     * @ORM\Column(type="text")
     */
    private $model;

    /**
     * @ORM\Column(type="float")
     */
    private $flight_duration;

    /**
     * @ORM\Column(type="text")
     */
    private $participant_name;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $round;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTraveldistance(): ?float
    {
        return $this->traveldistance;
    }

    public function setTraveldistance(float $traveldistance): self
    {
        $this->traveldistance = $traveldistance;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getFlightDuration(): ?float
    {
        return $this->flight_duration;
    }

    public function setFlightDuration(float $flight_duration): self
    {
        $this->flight_duration = $flight_duration;

        return $this;
    }

    public function getParticipantName(): ?string
    {
        return $this->participant_name;
    }

    public function setParticipantName(string $participant_name): self
    {
        $this->participant_name = $participant_name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(?int $round): self
    {
        $this->round = $round;

        return $this;
    }
}
