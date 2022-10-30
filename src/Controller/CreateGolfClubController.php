<?php

namespace App\Controller;

use App\Entity\GolfClub;
use App\Service\GolfClub\CreateGolfClub;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateGolfClubController extends AbstractController
{
    private CreateGolfClub $createGolfClub;

    /**
     * @param CreateGolfClub $createGolfClub
     */
    public function __construct(CreateGolfClub $createGolfClub)
    {
        $this->createGolfClub = $createGolfClub;
    }

    #[Route('/creategolfclub', name: 'app_create_golfclub')]
    public function index(Request $request): Response
    {
        $golfClub = new GolfClub();

        $form  = $this->createFormBuilder($golfClub)
            ->add('name', TextType::class)
            ->add('street', TextType::class)
            ->add('zipCode', TextType::class)
            ->add('city', TextType::class)
            ->add('websiteUrl', TextType::class)
            ->add('email', TextType::class)
            ->add('phone', TextType::class)
            ->add('imageUrl', TextType::class, )
            ->add('save', SubmitType::class, ['label' => 'Create Club'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $golfClub = $form->getData();

            $response = $this->createGolfClub->createNewGolfClub($golfClub);

            $response = json_decode($response->getContent(), true);

            return $this->redirectToRoute('app_golf_course', ['clubId' => $response['id']]);
        }

        return $this->renderForm('pages/create_golfClub/index.html.twig', ['form' => $form]);
    }
}
