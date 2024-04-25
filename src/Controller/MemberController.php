<?php

namespace App\Controller;

use App\Form\UserEmailType;
use App\Form\UserPasswordType;
use App\Form\UserUsernameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class MemberController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('member/profile.html.twig', [
            'bannerTitle' => 'TPOTDR | Profile',
        ]);
    }

    #[Route('/profile/edit/username', name: 'app_profile_edit_username')]
    public function editName(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $loggedInUser = $this->getUser();
        $form = $this->createForm(UserUsernameType::class, $loggedInUser);
        $form->handleRequest($request);

        if (!$loggedInUser->getRoles()) {
            $this->addFlash('danger', 'Something went wrong! Please try again later');
            $this->denyAccessUnlessGranted('ROLE_DENIED');
        } else if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('username')->getData();
            $loggedInUser->setUsername($username);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited username to: " . $username);
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('member/reset.html.twig', [
            'bannerTitle' => 'TPOTDR | Edit Username',
            'form' => $form,
        ]);
    }

    #[Route('/profile/edit/email', name: 'app_profile_edit_email')]
    public function editEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $loggedInUser = $this->getUser();
        $form = $this->createForm(UserEmailType::class, $loggedInUser);
        $form->handleRequest($request);

        if (!$loggedInUser->getRoles()) {
            $this->addFlash('danger', 'Something went wrong! Please try again later');
            $this->denyAccessUnlessGranted('ROLE_DENIED');
        } else if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $loggedInUser->setEmail($email);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited email to: " . $email);
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('member/reset.html.twig', [
            'bannerTitle' => 'TPOTDR | Edit Email',
            'form' => $form,
        ]);
    }

    #[Route('/profile/edit/password', name: 'app_profile_edit_password')]
    public function editPassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $loggedInUser = $this->getUser();
        $form = $this->createForm(UserPasswordType::class, $loggedInUser);
        $form->handleRequest($request);

        if (!$loggedInUser->getRoles()) {
            $this->addFlash('danger', 'Something went wrong! Please try again later');
            $this->denyAccessUnlessGranted('ROLE_DENIED');
        } else if ($form->isSubmitted() && $form->isValid()) {
            $loggedInUser->setPassword($userPasswordHasher->hashPassword(
                $loggedInUser,
                $form->get('plainPassword')->getData()
            ));

            $entityManager->flush();
            $this->addFlash('success', 'Successfully edited password!');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('member/reset.html.twig', [
            'bannerTitle' => 'TPOTDR | Edit Password',
            'form' => $form,
        ]);
    }
}
