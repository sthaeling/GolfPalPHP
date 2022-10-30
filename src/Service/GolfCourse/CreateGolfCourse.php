<?php

declare(strict_types=1);

namespace App\Service\GolfCourse;

use App\Entity\GolfCourse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateGolfCourse
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createNewGolfCourse(GolfCourse $courseData)
    {
        $entityManager = $this->managerRegistry->getManager();

        $golfCourseRepo = $entityManager->getRepository(GolfCourse::class);

        $existingResult = $golfCourseRepo->findOneBy(['name' => $courseData->getName(), 'golfClub' => $courseData->getGolfClub()]);

        if ($existingResult) {
            return new JsonResponse(['id' => $existingResult->getId()], 200);
        }

        $golfCourse = new GolfCourse();

        $golfCourse
            ->setName($courseData->getName())
            ->setHolesAmount($courseData->getHolesAmount())
            ->setGolfClub($courseData->getGolfClub());

        $entityManager->persist($golfCourse);

        $entityManager->flush();

        return new JsonResponse(['id' => $golfCourse->getId()], 200);
    }
}
