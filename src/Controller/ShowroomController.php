<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowroomController extends AbstractController
{
    #[Route('/showroom', name: 'app_showroom')]
    public function index(): Response
    {
        return $this->render('showroom/index.html.twig', [
            'controller_name' => 'ShowroomController',
        ]);
    }
}
