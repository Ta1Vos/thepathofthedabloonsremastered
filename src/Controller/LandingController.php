<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LandingController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_DISABLED')) {//Check if account is banned

        } else if ($this->isGranted('ROLE_DEACTIVATED')) {//Check if account is temporarily banned

        } else if ($this->isGranted('ROLE_USER')) {//Check if user is logged in
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

    #[Route('/deactivated', name: 'app_deactivated')]
    public function deactivated(): Response
    {
        $user = $this->getUser();

        return $this->render('landing/deactivated.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/disabled', name: 'app_disabled')]
    public function disabled(): Response
    {
        $user = $this->getUser();

        return $this->render('landing/disabled.twig', [
            'user' => $user,
        ]);
    }
}
