<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\UserHoleScore;
use App\Repository\GolfCourseRepository;
use App\Repository\HoleRepository;
use App\Service\Game\CreateGame;
use App\Service\User\SelectUser;
use App\Service\UserHoleScore\CreateUserHoleScore;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateGameController extends AbstractController
{
    private CreateGame $createGame;

    private SelectUser $selectUser;

    private GolfCourseRepository $golfCourseRepository;

    private HoleRepository $holeRepository;

    /**
     * @param CreateGame $createGame
     * @param SelectUser $selectUser
     * @param GolfCourseRepository $golfCourseRepository
     * @param HoleRepository $holeRepository
     */
    public function __construct(CreateGame $createGame, SelectUser $selectUser, GolfCourseRepository $golfCourseRepository, HoleRepository $holeRepository)
    {
        $this->createGame = $createGame;
        $this->selectUser = $selectUser;
        $this->golfCourseRepository = $golfCourseRepository;
        $this->holeRepository = $holeRepository;
    }

    #[Route('/creategame', name: 'app_create_game')]
    public function index(Request $request): Response
    {
        $newGame = new Game();
        $newGame->setDate(new DateTime());
        $newGame = $this->createGame->createNewGame($newGame);

        $courseId = $request->query->get('courseId');

        $course = $this->getSelectedCourse($courseId);

        if (count($newGame->getUserHoleScore()) >= count($course->getHoles())) {
            $newGame->setFinishedEntry(true);

            $this->createGame->updateFinished($newGame);

            $gameId = $newGame->getId();

            return $this->redirectToRoute('app_game_detail', ['gameId' => $gameId]);
        }

        $user = $this->getSelectedUser($request);

        $score = new UserHoleScore();

        $form = $this->createFormBuilder($score)
            ->add('score', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Score'])
            ->getForm();

        $currentHoleNumber = count($newGame->getUserHoleScore()) + 1;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scoreData = $form->getData();

            $hole = $this->holeRepository->findOneBy(['golfCourse' => $course, 'holeNumber' => $currentHoleNumber]);
            $scoreData->setHole($hole);
            $scoreData->setUser($user);
            $this->createGame->addScore($newGame, $scoreData);

            return $this->renderForm('pages/create_game/index.html.twig', [
                'form' => $form,
                'currentHole' => $currentHoleNumber,
            ]);
        }

        return $this->renderForm('pages/create_game/index.html.twig', [
            'form' => $form,
            'currentHole' => $currentHoleNumber,
        ]);
    }

    private function getSelectedCourse(string $courseId)
    {
        return $this->golfCourseRepository->find($courseId);
    }

    private function getSelectedUser(Request $request): ?User
    {
        return $this->selectUser->getSelectedUser($request);
    }
}
