<?php

declare(strict_types=1);

namespace App\Service\GolfClub;

use App\Entity\GolfClub;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateGolfClub
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createNewGolfClub(GolfClub $clubData)
    {
        $entityManager = $this->managerRegistry->getManager();

        $golfClubRepo = $entityManager->getRepository(GolfClub::class);

        $existingResult = $golfClubRepo->findOneBy(['name' => $clubData->getName()]);

        if ($existingResult) {
            return new JsonResponse(['id' => $existingResult->getId()], 200);
        }

        $golfClub = new GolfClub();

        $golfClub->setName($clubData->getName());
        $golfClub->setStreet($clubData->getStreet());
        $golfClub->setZipCode($clubData->getZipCode());
        $golfClub->setCity($clubData->getCity());
        $golfClub->setEmail($clubData->getEmail());
        $golfClub->setWebsiteUrl($clubData->getWebsiteUrl());
        $golfClub->setPhone($clubData->getPhone());
        $golfClub->setImageUrl($clubData->getImageUrl());

        $entityManager->persist($golfClub);

        $entityManager->flush();

        return new JsonResponse(['id' => $golfClub->getId()], 200);
    }
}
