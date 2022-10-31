<?php

namespace App\Controller;

use App\Entity\GolfClub;
use App\Entity\User;
use App\Service\User\CreateUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController extends AbstractController
{
    private CreateUser $createUser;

    /**
     * @param CreateUser $createUser
     */
    public function __construct(CreateUser $createUser)
    {
        $this->createUser = $createUser;
    }

    #[Route('/createuser', name: 'app_create_user')]
    public function index(Request $request): Response
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', TextType::class)
            ->add('handicap', TextType::class)
            ->add('phoneNumber', TextType::class, ['required' => false])
            ->add('save', SubmitType::class, ['label' => 'Create User'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();

            $response = $this->createUser->createNewUser($userData);

            $response = json_decode($response->getContent(), true);

            return $this->redirectToRoute('app_users', ['userId' => $response['id']]);
        }

        return $this->renderForm('pages/create_user/index.html.twig', [
            'form' => $form,
        ]);
    }
}
