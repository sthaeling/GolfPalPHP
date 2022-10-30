<?php

namespace App\Controller;

use App\Service\GolfClub\DisplayGolfClubs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GolfClubController extends AbstractController
{
    private DisplayGolfClubs $displayGolfClubs;

    /**
     * @param DisplayGolfClubs $displayGolfClubs
     */
    public function __construct(DisplayGolfClubs $displayGolfClubs)
    {
        $this->displayGolfClubs = $displayGolfClubs;
    }

    #[Route('/golfclub', name: 'app_golfclub')]
    public function index(): Response
    {
        $clubs = $this->displayGolfClubs->mapGolfClubsForListing();

        return $this->render('pages/golfClub/index.html.twig', [
            'clubs' => $clubs
        ]);
    }
}
