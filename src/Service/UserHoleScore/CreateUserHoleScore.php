<?php

declare(strict_types=1);

namespace App\Service\UserHoleScore;

use App\Entity\Game;
use App\Entity\GolfCourse;
use App\Entity\User;
use App\Entity\UserHoleScore;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateUserHoleScore
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createNewScore(UserHoleScore $scoreData, GolfCourse $course, int $currentHoleNumber, User $user, Game $game)
    {
        $entityManager = $this->managerRegistry->getManager();

        foreach ($course->getHoles() as $hole) {
            if ($hole->getHoleNumber() === $currentHoleNumber) {
                $currentHole = $hole;
                break;
            }
        }


        dd($game);
        $scoreData->setGame($game);

        $entityManager->persist($scoreData);

        $entityManager->flush();

        return new JsonResponse(['id' => $scoreData->getId()], 200);
    }
}
