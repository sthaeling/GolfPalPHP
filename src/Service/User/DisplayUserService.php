<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Repository\UserRepository;

class DisplayUserService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        $users = $this->userRepository->getUsers();
        return $users;
    }

    public function getUserById(string $userId)
    {
        return $this->userRepository->find($userId);
    }
}
