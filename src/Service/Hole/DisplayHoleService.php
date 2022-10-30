<?php

declare(strict_types=1);

namespace App\Service\Hole;

use App\Entity\Hole;
use App\Repository\HoleRepository;

class DisplayHoleService
{
    private HoleRepository $holeRepository;

    /**
     * @param HoleRepository $holeRepository
     */
    public function __construct(HoleRepository $holeRepository)
    {
        $this->holeRepository = $holeRepository;
    }

    public function mapGolfCoursesForListing(string $courseId = null)
    {
        $holes = $this->holeRepository->getHoles($courseId);

        if ($courseId) {
            foreach ($holes as $hole) {
                assert($hole instanceof Hole);
                $course = $hole->getGolfCourse();

                $hole->courseHolesAmount = $course?->getHolesAmount();
            }
        }

        return $holes;
    }
}
