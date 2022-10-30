<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateGolfCourseController extends AbstractController
{
    #[Route('/creategolfcourse', name: 'app_create_golf_course')]
    public function index(): Response
    {
        return $this->render('create_golf_course/index.html.twig', [
            'controller_name' => 'CreateGolfCourseController',
        ]);
    }
}
