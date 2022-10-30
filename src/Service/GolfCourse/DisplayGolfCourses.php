<?php

declare(strict_types=1);

namespace App\Service\GolfCourse;

use App\Entity\GolfClub;
use App\Entity\GolfCourse;
use App\Repository\GolfCourseRepository;

class DisplayGolfCourses
{
    private GolfCourseRepository $golfCourseRepository;

    /**
     * @param GolfCourseRepository $golfCourseRepository
     */
    public function __construct(GolfCourseRepository $golfCourseRepository)
    {
        $this->golfCourseRepository = $golfCourseRepository;
    }

    public function mapGolfCoursesForListing(string $golfClubId = null)
    {
        $golfCourses = $this->golfCourseRepository->getAllEntries($golfClubId);

        foreach ($golfCourses as $golfCourse) {
            assert($golfCourse instanceof GolfCourse);
            $holes = $golfCourse->getHoles();
            $totalPar = 0;
            $totalDistance = 0;

            foreach ($holes as $hole) {
                $totalPar += $hole->getPar();
                $totalDistance += $hole->getDistance();
            }

            $golfCourse->totalPar = $totalPar > 0 ? $totalPar : null;
            $golfCourse->totalDistance = $totalDistance > 0 ? $totalDistance : null;
        }

        return $golfCourses;
    }
}
