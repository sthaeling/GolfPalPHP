<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateGolfClubController extends AbstractController
{


    #[Route('/creategolfclub', name: 'app_create_golfclub')]
    public function index(): Response
    {


        return $this->render('create_golfClub/index.html.twig', [
            'golfClubs' => $clubs,
        ]);
    }
}
