<?php

namespace App\Controller;

use App\Entity\GolfClub;
use App\Entity\GolfCourse;
use App\Entity\Hole;
use App\Repository\GolfCourseRepository;
use App\Repository\HoleRepository;
use App\Service\Hole\CreateHole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateHoleController extends AbstractController
{
    private CreateHole $createHole;

    private GolfCourseRepository $golfCourseRepository;

    /**
     * @param CreateHole $createHole
     * @param GolfCourseRepository $golfCourseRepository
     */
    public function __construct(CreateHole $createHole, GolfCourseRepository $golfCourseRepository)
    {
        $this->createHole = $createHole;
        $this->golfCourseRepository = $golfCourseRepository;
    }

    #[Route('/createhole', name: 'app_create_hole')]
    public function index(Request $request): Response
    {
        $hole = new Hole();

        $form = $this->createFormBuilder($hole)
            ->add('holeNumber', IntegerType::class)
            ->add('par', IntegerType::class)
            ->add('hcp', IntegerType::class)
            ->add('distance', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Hole'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hole = $form->getData();
            $golfCourse = $this->golfCourseRepository->find($request->query->get('courseId'));
            assert($hole instanceof Hole);
            $hole->setGolfCourse($golfCourse);

            $this->createHole->createNewHole($hole);

            return $this->redirectToRoute('app_hole', ['courseId' => $golfCourse?->getId()]);
        }

        return $this->renderForm('pages/create_hole/index.html.twig', ['form' => $form]);
    }
}
