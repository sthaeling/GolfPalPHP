<?php

namespace App\Controller;

use App\Service\User\DisplayUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private DisplayUserService $displayUserService;

    /**
     * @param DisplayUserService $displayUserService
     */
    public function __construct(DisplayUserService $displayUserService)
    {
        $this->displayUserService = $displayUserService;
    }

    #[Route('/users', name: 'app_users')]
    public function index(): Response
    {
        $users = $this->displayUserService->getAllUsers();

        return $this->render('pages/user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
