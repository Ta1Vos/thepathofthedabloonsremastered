<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEmailType;
use App\Form\UserPasswordType;
use App\Form\UserUsernameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_USER")]
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

        //Build the form for the username
        $form = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'attr' => [
                    'value' => $loggedInUser->getUsername()
                ]
            ])
            ->add('submit', SubmitType::class)
            ->getForm();


//        $form = $this->createForm(UserUsernameType::class, $loggedInUser->getUsername());
        $form->handleRequest($request);

        if (!$loggedInUser->getRoles()) {
            $this->addFlash('danger', 'Something went wrong! Please try again later');
            $this->denyAccessUnlessGranted('ROLE_DENIED');
        } else if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('username')->getData();//Fetch username

            $foundUsername = $entityManager->getRepository(User::class)->findBy(['username' => $username]);//Search for duplicates

            if (count($foundUsername) > 0) {//Extra check to see if there are no duplicates
                $this->addFlash('warning', 'This username already exists!');
                return $this->redirectToRoute('app_profile_edit_username');
            } else {
                $loggedInUser->setUsername($username);
                $entityManager->flush();
                $this->addFlash('success', "Successfully edited username to: " . $username);
                return $this->redirectToRoute('app_profile');
            }
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

        if (!$loggedInUser->getRoles()) {//Extra check to see if there are no duplicates
            $this->addFlash('danger', 'Something went wrong! Please try again later');
        } else if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();//Fetch email

            $foundEmail = $entityManager->getRepository(User::class)->findBy(['email' => $email]);

            if (count($foundEmail) > 0) {
                $this->addFlash('warning', 'This email already exists!');
            } else {
                $loggedInUser->setEmail($email);
                $entityManager->flush();
                $this->addFlash('success', "Successfully edited username to: " . $email);
                return $this->redirectToRoute('app_profile');
            }

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
        $form->add('submit', SubmitType::class);
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
