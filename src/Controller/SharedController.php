<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SharedController extends AbstractController
{
    #[Route('/shared', name: 'app_shared')]
    public function index(): Response
    {
        return $this->render('shared/dashboard.html.twig', [
            'controller_name' => 'SharedController',
        ]);
    }
}
