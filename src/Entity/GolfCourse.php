<?php

namespace App\Entity;

use App\Repository\GolfCourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GolfCourseRepository::class)]
class GolfCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $holesAmount = null;

    #[ORM\ManyToOne(inversedBy: 'golfCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GolfClub $golfClub = null;

    #[ORM\OneToMany(mappedBy: 'golfCourse', targetEntity: Hole::class, orphanRemoval: true)]
    private Collection $holes;

    public function __construct()
    {
        $this->holes = new ArrayCollection();
    }

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

    public function getHolesAmount(): ?int
    {
        return $this->holesAmount;
    }

    public function setHolesAmount(int $holesAmount): self
    {
        $this->holesAmount = $holesAmount;

        return $this;
    }

    public function getGolfClub(): ?GolfClub
    {
        return $this->golfClub;
    }

    public function setGolfClub(?GolfClub $golfClub): self
    {
        $this->golfClub = $golfClub;

        return $this;
    }

    /**
     * @return Collection<int, Hole>
     */
    public function getHoles(): Collection
    {
        return $this->holes;
    }

    public function addHole(Hole $hole): self
    {
        if (!$this->holes->contains($hole)) {
            $this->holes->add($hole);
            $hole->setGolfCourse($this);
        }

        return $this;
    }

    public function removeHole(Hole $hole): self
    {
        if ($this->holes->removeElement($hole)) {
            // set the owning side to null (unless already changed)
            if ($hole->getGolfCourse() === $this) {
                $hole->setGolfCourse(null);
            }
        }

        return $this;
    }
}
