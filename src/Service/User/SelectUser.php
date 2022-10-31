<?php

declare(strict_types=1);

namespace App\Service\User;

use App\CookieHelper;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class SelectUser
{
    private CookieHelper $cookieHelper;

    private UserRepository $userRepository;

    /**
     * @param CookieHelper $cookieHelper
     * @param UserRepository $userRepository
     */
    public function __construct(CookieHelper $cookieHelper, UserRepository $userRepository)
    {
        $this->cookieHelper = $cookieHelper;
        $this->userRepository = $userRepository;
    }

    public function selectUser(string $userId): bool
    {
        return $this->cookieHelper->setCookie('userId', $userId);
    }

    public function getSelectedUser(Request $request): ?User
    {
        $userId = $this->cookieHelper->readCookie('userId', $request);

        return $this->userRepository->find($userId);
    }
}
