<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleAndResultsRepository")
 */
class ScheduleAndResults
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $resultId;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamAId;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamBId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreA;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreB;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResultId(): ?int
    {
        return $this->resultId;
    }

    public function setResultId(int $resultId): self
    {
        $this->resultId = $resultId;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTeamAId(): ?int
    {
        return $this->teamAId;
    }

    public function setTeamAId(int $teamAId): self
    {
        $this->teamAId = $teamAId;

        return $this;
    }

    public function getTeamBId(): ?int
    {
        return $this->teamBId;
    }

    public function setTeamBId(int $teamBId): self
    {
        $this->teamBId = $teamBId;

        return $this;
    }

    public function getScoreA()
    {
        return $this->scoreA;
    }

    public function setScoreA($scoreA): self
    {
        $this->scoreA = $scoreA;

        return $this;
    }

    public function getScoreB()
    {
        return $this->scoreB;
    }

    public function setScoreB($scoreB): self
    {
        $this->scoreB = $scoreB;

        return $this;
    }
}
