<?php

namespace App\Controller;

use App\Service\User\DisplayUserService;
use App\Service\User\SelectUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserSelectController extends AbstractController
{
    private SelectUser $selectUser;

    private DisplayUserService $displayUserService;

    /**
     * @param SelectUser $selectUser
     * @param DisplayUserService $displayUserService
     */
    public function __construct(SelectUser $selectUser, DisplayUserService $displayUserService)
    {
        $this->selectUser = $selectUser;
        $this->displayUserService = $displayUserService;
    }

    #[Route('/userselect', name: 'app_user_select')]
    public function index(Request $request): Response
    {
        $userId = $request->query->get('userId');

        $this->selectUser->selectUser($userId);

        $pageContent = [];

        if ($userId) {
            $pageContent['loggedInUser'] = $this->displayUserService->getUserById($userId);
        }

        return $this->render('pages/user_select/index.html.twig', $pageContent);
    }
}
