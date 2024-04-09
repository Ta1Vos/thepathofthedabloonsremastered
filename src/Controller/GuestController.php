<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GuestController extends AbstractController
{
    #[Route('/guest', name: 'app_guest')]
    public function index(): Response
    {
        return $this->render('guest/index.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }
}
