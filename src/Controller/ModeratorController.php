<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UsernameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            'bannerTitle' => "TPOTDR | MODERATOR",
        ]);
    }

    #[Route('/moderator/member-search', name: 'app_mod_member_searching')]
    public function modMemberSearch(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERATOR');
        $userList = [];

        $form = $this->createForm(UsernameType::class);
        $form->add('search_all', SubmitType::class, [
            'attr' => [
                'label' => 'Search all'
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //If search all
            $userList = $entityManager->getRepository(User::class)->findAll();
            //If search one
        }

        return $this->render('moderator/member_search.html.twig', [
            'bannerTitle' => "TPOTDR | SEARCH",
            'users' => $userList,
            'form' => $form
        ]);
    }

    #[Route('/moderator/member-edit', name: 'app_mod_member_editing')]
    public function modMemberEdit(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERATOR');
        return $this->render('moderator/member_editing.html.twig', [
            'bannerTitle' => "TPOTDR | MODERATE",
        ]);
    }
}
