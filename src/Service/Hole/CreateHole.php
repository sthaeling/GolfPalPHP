<?php

declare(strict_types=1);

namespace App\Service\Hole;

use App\Entity\Hole;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateHole
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createNewHole(Hole $holeData)
    {
        $entityManager = $this->managerRegistry->getManager();

        $holeRepo = $entityManager->getRepository(Hole::class);

        $existingResult = $holeRepo->findOneBy(['holeNumber' => $holeData->getHoleNumber(), 'golfCourse' => $holeData->getGolfCourse()]);

        if ($existingResult) {
            return new JsonResponse(['id' => $existingResult->getId()], 200);
        }

        $hole = new Hole();

        $hole->setHoleNumber($holeData->getHoleNumber());
        $hole->setDistance($holeData->getDistance());
        $hole->setPar($holeData->getPar());
        $hole->setHcp($holeData->getHcp());
        $hole->setGolfCourse($holeData->getGolfCourse());

        $entityManager->persist($hole);

        $entityManager->flush();

        return new JsonResponse(['id' => $hole->getId()], 200);
    }
}
