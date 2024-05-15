<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModeratorController extends AbstractController
{
    #[Route('/moderator', name: 'app_moderator')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERATOR');
        return $this->render('moderator/dashboard.html.twig', [
            'controller_name' => 'ModeratorController',
            'bannerTitle' => "TPOTDR | MODERATOR",
        ]);
    }

    #[Route('/moderator/member-search', name: 'app_mod_member_searching')]
    public function modMemberSearch(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERATOR');
        return $this->render('moderator/member_editing.html.twig', [
            'controller_name' => 'ModeratorController',
            'bannerTitle' => "TPOTDR | SEARCH",
        ]);
    }

    #[Route('/moderator/member-edit', name: 'app_mod_member_editing')]
    public function modMemberEdit(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERATOR');
        return $this->render('moderator/member_editing.html.twig', [
            'controller_name' => 'ModeratorController',
            'bannerTitle' => "TPOTDR | MODERATE",
        ]);
    }
}
