<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameListingController extends AbstractController
{
    private GameRepository $gameRepository;

    /**
     * @param GameRepository $gameRepository
     */
    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    #[Route('/gamelisting', name: 'app_game_listing')]
    public function index(): Response
    {
        $games = $this->gameRepository->findAll();

        foreach ($games as $game) {
            $totalPar = 0;
            $totalScore = 0;

            if ($firstScore = $game->getUserHoleScore()->first()) {
                $user = $firstScore->getUser();
                $user?->setHandicap($user?->getHandicap());
                $game->user = $user;
                $scores = $game->getUserHoleScore();
                $course = $firstScore->getHole()?->getGolfCourse();
                $course?->getHoles();
                $club = $course?->getGolfClub();
                $club?->getName();
                $game->course = $course;
                $game->club = $club;

                foreach ($scores as $item) {
                    $hole = $item->getHole();
                    $hole?->setHoleNumber($hole?->getHoleNumber());
                    $item->setHole($hole);
                    $totalScore += $item->getScore();

                    if ($item->getScore() !== 0) {
                        $totalPar += $item->getHole()?->getPar();
                    }
                }
            }

            $game->totalPar = $totalPar;
            $game->totalScore = $totalScore;
        }

        return $this->render('pages/game_listing/index.html.twig', [
            'games' => $games,
        ]);
    }
}
