<?php

namespace App\Entity;

use App\Repository\HoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoleRepository::class)]
class Hole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $holeNumber = null;

    #[ORM\Column]
    private ?int $par = null;

    #[ORM\Column]
    private ?int $distance = null;

    #[ORM\Column]
    private ?int $hcp = null;

    #[ORM\ManyToOne(inversedBy: 'holes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GolfCourse $golfCourse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoleNumber(): ?int
    {
        return $this->holeNumber;
    }

    public function setHoleNumber(int $holeNumber): self
    {
        $this->holeNumber = $holeNumber;

        return $this;
    }

    public function getPar(): ?int
    {
        return $this->par;
    }

    public function setPar(int $par): self
    {
        $this->par = $par;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getHcp(): ?int
    {
        return $this->hcp;
    }

    public function setHcp(int $hcp): self
    {
        $this->hcp = $hcp;

        return $this;
    }

    public function getGolfCourse(): ?GolfCourse
    {
        return $this->golfCourse;
    }

    public function setGolfCourse(?GolfCourse $golfCourse): self
    {
        $this->golfCourse = $golfCourse;

        return $this;
    }
}
