<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function modMemberSearch(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userList = $entityManager->getRepository(User::class)->findAll();

        $this->denyAccessUnlessGranted('ROLE_MODERATOR');
        return $this->render('moderator/member_editing.html.twig', [
            'controller_name' => 'ModeratorController',
            'bannerTitle' => "TPOTDR | SEARCH",
            'users' => $userList,
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
