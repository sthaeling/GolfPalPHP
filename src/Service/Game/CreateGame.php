<?php

declare(strict_types=1);

namespace App\Service\Game;

use App\Entity\Game;
use App\Entity\UserHoleScore;
use Doctrine\Persistence\ManagerRegistry;

class CreateGame
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createNewGame(Game $gameData)
    {
        $entityManager = $this->managerRegistry->getManager();

        $gameRepo = $entityManager->getRepository(Game::class);

        $gameData->setNumber(0);
        $gameData->setFinishedEntry(false);
        $existingResult = $gameRepo->findOneBy(['date' => $gameData->getDate(), 'number' => $gameData->getNumber()]);

        if ($existingResult) {
            return $existingResult;
        }

        $entityManager->persist($gameData);

        $entityManager->flush();

        return $gameData;
    }

    public function addScore(Game $gameData, UserHoleScore $userHoleScore)
    {
        $entityManager = $this->managerRegistry->getManager();

        $gameRepo = $entityManager->getRepository(Game::class);

        $existingResult = $gameRepo->findOneBy(['date' => $gameData->getDate(), 'number' => $gameData->getNumber()]);
        assert($existingResult instanceof Game);

        if ($existingResult->isFinishedEntry()) {
            $number = $gameData->getNumber();

            $gameData->setNumber(++$number);

            $gameData = $this->createNewGame($gameData);
        }

        if ($existingResult) {
            $entityManager->persist($userHoleScore);

            $gameData->addUserHoleScore($userHoleScore);

            $entityManager->persist($gameData);

            $entityManager->flush();
        }
    }

    public function updateFinished(Game $newGame)
    {
        $entityManager = $this->managerRegistry->getManager();

        $entityManager->persist($newGame);

        $entityManager->flush();
    }
}
