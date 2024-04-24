<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'app_member')]
    public function memberIndex(): Response
    {
        if (!$this->getUser()) {//Prevents guests from going to user pages.
            $this->addFlash('danger', 'Something went wrong! (You are not logged in)');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        if (!$this->getUser()) {//Prevents guests from going to user pages.
            $this->addFlash('danger', 'Something went wrong! (You are not logged in)');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('member/profile.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }
}
