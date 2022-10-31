<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\UserHoleScoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameDetailController extends AbstractController
{
    private GameRepository $gameRepository;
    private UserHoleScoreRepository $userHoleScoreRepository;

    /**
     * @param GameRepository $gameRepository
     * @param UserHoleScoreRepository $userHoleScoreRepository
     */
    public function __construct(GameRepository $gameRepository, UserHoleScoreRepository $userHoleScoreRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->userHoleScoreRepository = $userHoleScoreRepository;
    }

    #[Route('/gamedetail', name: 'app_game_detail')]
    public function index(Request $request): Response
    {
        $gameId = $request->query->get('gameId');
        $game = $this->gameRepository->find($gameId);

        $score = $this->userHoleScoreRepository->findBy(['game' => $game]);

        $totalScore = 0;
        $totalPar = 0;

        $firstScore = $game?->getUserHoleScore()->first();
        $user = $firstScore->getUser();
        $user?->setHandicap($user?->getHandicap());

        foreach ($score as $item) {
            $hole = $item->getHole();
            $hole?->setHoleNumber($hole?->getHoleNumber());
            $item->setHole($hole);
            $totalScore += $item->getScore();

            if ($item->getScore() !== 0) {
                $totalPar += $item->getHole()?->getPar();
            }
        }

        return $this->render('pages/game_detail/index.html.twig', [
            'game' => $game,
            'score' => $score,
            'totalScore' => $totalScore,
            'totalPar' => $totalPar,
            'user' => $user,
        ]);
    }
}
