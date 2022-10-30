<?php

namespace App\Controller;

use App\Entity\GolfCourse;
use App\Repository\GolfClubRepository;
use App\Service\GolfCourse\CreateGolfCourse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateGolfCourseController extends AbstractController
{
    private CreateGolfCourse $createGolfCourse;

    private GolfClubRepository $golfClubRepository;

    /**
     * @param CreateGolfCourse $createGolfCourse
     * @param GolfClubRepository $golfClubRepository
     */
    public function __construct(CreateGolfCourse $createGolfCourse, GolfClubRepository $golfClubRepository)
    {
        $this->createGolfCourse = $createGolfCourse;
        $this->golfClubRepository = $golfClubRepository;
    }

    #[Route('/creategolfcourse', name: 'app_create_golf_course')]
    public function index(Request $request): Response
    {
        $golfCourse = new GolfCourse();

        $form = $this->createFormBuilder($golfCourse)
            ->add('name', TextType::class)
            ->add('holesAmount', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Course'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $golfCourse = $form->getData();
            $golfClub = $this->golfClubRepository->find($request->query->get('clubId'));
            assert($golfCourse instanceof GolfCourse);
            $golfCourse->setGolfClub($golfClub);

            $response = $this->createGolfCourse->createNewGolfCourse($golfCourse);

            $response = json_decode($response->getContent(), true);

            return $this->redirectToRoute('app_hole', ['courseId' => $response['id']]);
        }

        return $this->renderForm('pages/create_golf_course/index.html.twig', ['form' => $form]);
    }
}
