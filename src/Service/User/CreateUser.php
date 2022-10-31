<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateUser
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createNewUser(User $userData)
    {
        $entityManager = $this->managerRegistry->getManager();

        $holeRepo = $entityManager->getRepository(User::class);

        $existingResult = $holeRepo->findOneBy(['email' => $userData->getEmail()]);

        if ($existingResult) {
            return new JsonResponse(['id' => $existingResult->getId()], 200);
        }

        $user = new User();

        $user->setEmail($userData->getEmail());
        $user->setFirstName($userData->getFirstName());
        $user->setLastName($userData->getLastName());
        $user->setHandicap($userData->getHandicap());
        $user->setPhoneNumber($userData->getPhoneNumber() ?? null);
        $user->setPassword($userData->getPassword() ?? 'placeholder');

        $entityManager->persist($user);

        $entityManager->flush();

        return new JsonResponse(['id' => $user->getId()], 200);
    }
}
