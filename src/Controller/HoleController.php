<?php

namespace App\Controller;

use App\Service\Hole\DisplayHoleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HoleController extends AbstractController
{
    private DisplayHoleService $displayHoleService;

    /**
     * @param DisplayHoleService $displayHoleService
     */
    public function __construct(DisplayHoleService $displayHoleService)
    {
        $this->displayHoleService = $displayHoleService;
    }

    #[Route('/hole', name: 'app_hole')]
    public function index(Request $request): Response
    {
        $golfCourseId = $request->query->get('courseId');
        $holes = $this->displayHoleService->mapGolfCoursesForListing($golfCourseId);

        return $this->render('pages/hole/index.html.twig', [
            'holes' => $holes,
        ]);
    }
}
