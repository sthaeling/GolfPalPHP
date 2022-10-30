<?php

namespace App\Controller;

use App\Service\GolfCourse\DisplayGolfCourses;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GolfCourseController extends AbstractController
{
    private DisplayGolfCourses $displayGolfCourses;

    /**
     * @param DisplayGolfCourses $displayGolfCourses
     */
    public function __construct(DisplayGolfCourses $displayGolfCourses)
    {
        $this->displayGolfCourses = $displayGolfCourses;
    }

    #[Route('/golfcourse', name: 'app_golf_course')]
    public function index(Request $request): Response
    {
        $golfClubId = $request->query->get('clubId');
        $golfCourses = $this->displayGolfCourses->mapGolfCoursesForListing($golfClubId);

        return $this->render('pages/golf_course/index.html.twig', [
            'golfCourses' => $golfCourses,
        ]);
    }
}
