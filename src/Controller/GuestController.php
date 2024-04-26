<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GuestController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_USER')) {//Check if user is logged in
            //Check for any special roles
            if ($this->isGranted('ROLE_MODERATOR')) {
                return $this->render('guest/index.html.twig', [

                ]);
            } else if ($this->isGranted('ROLE_ADMIN')) {
                return $this->render('guest/index.html.twig', [

                ]);
            }

            return $this->render('guest/index.html.twig', [

            ]);
        }

        return $this->render('guest/index.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }

    #[Route('/aboutme', name: 'app_about')]
    public function aboutMe(): Response
    {
        return $this->render('guest/aboutme.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }

    #[Route('/settings', name: 'app_guest_settings')]
    public function guestSettings(): Response
    {
        return $this->render('guest/settings.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }
}
