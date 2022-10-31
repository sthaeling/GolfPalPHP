<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: UserHoleScore::class)]
    private Collection $UserHoleScore;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?bool $finishedEntry = null;

    public function __construct()
    {
        $this->UserHoleScore = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, UserHoleScore>
     */
    public function getUserHoleScore(): Collection
    {
        return $this->UserHoleScore;
    }

    public function addUserHoleScore(UserHoleScore $userHoleScore): self
    {
        if (!$this->UserHoleScore->contains($userHoleScore)) {
            $this->UserHoleScore->add($userHoleScore);
            $userHoleScore->setGame($this);
        }

        return $this;
    }

    public function removeUserHoleScore(UserHoleScore $userHoleScore): self
    {
        if ($this->UserHoleScore->removeElement($userHoleScore)) {
            // set the owning side to null (unless already changed)
            if ($userHoleScore->getGame() === $this) {
                $userHoleScore->setGame(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function isFinishedEntry(): ?bool
    {
        return $this->finishedEntry;
    }

    public function setFinishedEntry(bool $finishedEntry): self
    {
        $this->finishedEntry = $finishedEntry;

        return $this;
    }
}
