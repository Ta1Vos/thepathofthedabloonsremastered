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

        $searchForm = $this->createForm(UsernameType::class);
        $selectAllForm = $this->createFormBuilder()
            ->add('search_all', SubmitType::class, [
                'attr' => [
                    'label' => 'Search all'
                ]
            ])
            ->getForm();

        $searchForm->handleRequest($request);
        $selectAllForm->handleRequest($request);

        //If search all
        if ($selectAllForm->isSubmitted() && $selectAllForm->isValid()) {
            $userList = $entityManager->getRepository(User::class)->findAll();
        } else if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            //If search one
            $result = $searchForm->getData();
            $searchQueryResult = $result['username'];
            if (strlen($searchQueryResult) > 0) {
                $userList = $entityManager->getRepository(User::class)->findNameBySearchQuery($searchQueryResult);
            } else {
                $userList = $entityManager->getRepository(User::class)->findAll();//Find all if nothing has been input
            }
        }

        return $this->render('moderator/member_search.html.twig', [
            'bannerTitle' => "TPOTDR | SEARCH",
            'users' => $userList,
            'searchForm' => $searchForm,
            'searchAllForm' => $selectAllForm,
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
