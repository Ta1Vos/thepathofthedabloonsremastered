<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UsernameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
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
    public function modMemberSearch(FormFactoryInterface $formFactory, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERATOR');
        $userList = [];

        //Create named builder to prevent duplicate error.
        $searchForm = $formFactory->createNamedBuilder('SearchQuery', UsernameType::class)->getForm();

        $searchForm->handleRequest($request);
        //If search query
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $result = $searchForm->getData();
            $searchQueryResult = $result['username'];

            if (strlen($searchQueryResult) > 0) {
                return $this->redirectToRoute('app_mod_member_searching', ['query' => $searchQueryResult]);
            } else {
                return $this->redirectToRoute('app_mod_member_searching', ['query' => '!all']);//Find all if nothing has been input
            }
        }

        //Create named builder to prevent duplicate error.
        $selectAllForm = $formFactory->createNamedBuilder('SearchAll')
            ->add('search_all', SubmitType::class, [
                'attr' => [
                    'label' => 'Search all'
                ]
            ])
            ->getForm();
        ;

        //If search all
        $selectAllForm->handleRequest($request);
        if ($selectAllForm->isSubmitted() && $selectAllForm->isValid()) {
            return $this->redirectToRoute('app_mod_member_searching', ['query' => '!all']);
        }

        //handle GET request and load in the right things
        if ($request->get('query')) {
            $query = $request->get('query');

            if ($query == '!all') {
                $userList = $entityManager->getRepository(User::class)->findAll();
            } else {
                $userList = $entityManager->getRepository(User::class)->findNameBySearchQuery($query);
            }
        }

        //Put selected users in array, suitable for the ChoiceType form child.
        $selectableUsers = [];
        foreach ($userList as $user) {
            $selectableUsers[$user->getUsername()] = $user->getId();
        }

        //Create named builder to prevent duplicate error.
        $moderateUserForm = $formFactory->createNamedBuilder('moderateUser')
            ->add('select', ChoiceType::class, [
                'choices' =>  $selectableUsers,
//                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'label' => 'Moderate User'
                ]
            ])
            ->getForm();
        $moderateUserForm->handleRequest($request);

//        dd($moderateUserForm->getData());
        //Double verify if user id is valid, then send User to moderation page.
        if ($moderateUserForm->isSubmitted() && $moderateUserForm->isValid()) {
            $userId = $moderateUserForm->getData()['select'];//Get the select from the form

            //Check if exist
            if ($entityManager->getRepository(User::class)->find($userId)) {
                return $this->redirectToRoute('app_mod_member_editing', ['id' => $userId]);
            }
        }

        return $this->render('moderator/member_search.html.twig', [
            'bannerTitle' => "TPOTDR | SEARCH",
            'users' => $userList,
            'searchForm' => $searchForm,
            'searchAllForm' => $selectAllForm,
            'moderateUserForm' => $moderateUserForm
        ]);
    }

    #[Route('/moderator/member-edit/{id}', name: 'app_mod_member_editing')]
    public function modMemberEdit(int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERATOR');
        return $this->render('moderator/member_editing.html.twig', [
            'bannerTitle' => "TPOTDR | MODERATE",
        ]);
    }
}
