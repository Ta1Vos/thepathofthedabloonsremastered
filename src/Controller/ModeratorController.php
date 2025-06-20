<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEmailType;
use App\Form\UsernameType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[IsGranted("ROLE_USER")]
class ModeratorController extends AbstractController
{
    #[Route('/moderator', name: 'app_moderator')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted(new Expression('is_granted("ROLE_MODERATOR") or is_granted("ROLE_ADMIN")'));
        return $this->render('moderator/dashboard.html.twig', [
            'bannerTitle' => "TPOTDR | MODERATOR",
        ]);
    }

    #[Route('/moderator/member-search', name: 'app_mod_member_searching')]
    public function modMemberSearch(FormFactoryInterface $formFactory, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted(new Expression('is_granted("ROLE_MODERATOR") or is_granted("ROLE_ADMIN")'));
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
            ->getForm();;

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
                'choices' => $selectableUsers,
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

            if (!is_int($userId)) {
                $this->addFlash('danger', 'Please select an User before proceeding.');
                return $this->redirectToRoute('app_mod_member_searching');
            }

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
    public function modMemberEdit(FormFactoryInterface $formFactory, Request $request,  UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted(new Expression('is_granted("ROLE_MODERATOR") or is_granted("ROLE_ADMIN")'));
        //Check if a user has been selected
        if (!is_int($id)) {
            $this->addFlash('warning', 'Please select an User before proceeding.');
            return $this->redirectToRoute('app_mod_member_searching');
        }

        $user = $entityManager->getRepository(User::class)->find($id);

        $userDeactivationForm = $formFactory->createNamedBuilder('deactiveUser')
            ->add('deactivate-time', DateTimeType::class, [
                'label' => 'Time for deactivation',
                'data' => new \DateTime('now'),
                'widget' => 'single_text'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Deactivate User',
                'attr' => [
                    'class' => 'btn btn-danger mt-2 w-100'
                ]
            ])
            ->getForm();
        $userDeactivationForm->handleRequest($request);

        if ($userDeactivationForm->isSubmitted() && $userDeactivationForm->isValid()) {
            $formData = $userDeactivationForm->getData();

            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                $this->addFlash('danger', 'WARNING! Cannot deactivate Administrators.');
                return $this->redirectToRoute('app_mod_member_editing', ['id' => $id]);
            } //Check if the deactivation date is not in the past
            else if ($formData['deactivate-time'] < new \DateTime('now')) {
                $this->addFlash('danger', 'Time for deactivation cannot be in the past.');
                return $this->redirectToRoute('app_mod_member_editing', ['id' => $id]);
            }

            $user->setDeactivationTime($formData['deactivate-time']);

            $roles = $user->getRoles();
            //Check if the user has the ROLE_USER and remove it if the user has it so they get denied from most pages.
            if (in_array('ROLE_USER', $roles)) {
                unset($roles[array_search("ROLE_USER", $roles)]);
            }
            //Check if the user doesn't already have the ROLE_DEACTIVATED
            if (!in_array('ROLE_DEACTIVATED', $roles)) {
                //Add deactivated role
                $roles = ['ROLE_DEACTIVATED'];
                $user->setRoles($roles);
            }

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'User deactivation was successful.');
        }

        if (!$user->isDisabled()) {//If user is NOT disabled
            $userDisableForm = $formFactory->createNamedBuilder('disableUser')
                ->add('usernameRetype', TextType::class, [
                    'label' => '(Fill in username to confirm disable)',
                    'attr' => [
                        'placeholder' => $user->getUsername(),
                        'autocomplete' => 'off'
                    ]
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Disable User (BAN)',
                    'attr' => [
                        'class' => 'btn btn-danger mt-2 mb-4 w-100'
                    ]
                ])
                ->getForm();
        } else {//If user IS disabled
            $userDisableForm = $formFactory->createNamedBuilder('disableUser')
                ->add('usernameRetype', TextType::class, [
                    'label' => '(Fill in username to confirm activation)',
                    'attr' => [
                        'placeholder' => $user->getUsername(),
                        'autocomplete' => 'off'
                    ]
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Activate User (unban)',
                    'attr' => [
                        'class' => 'btn btn-danger mt-2 mb-4 w-100'
                    ]
                ])
                ->getForm();
        }
        $userDisableForm->handleRequest($request);

        if ($userDisableForm->isSubmitted() && $userDisableForm->isValid()) {
            $formData = $userDisableForm->getData();

            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                $this->addFlash('danger', 'WARNING! Cannot disable Administrators.');
                return $this->redirectToRoute('app_mod_member_editing', ['id' => $id]);
            }

            //If username validation fails
            if ($formData["usernameRetype"] != $user->getUsername()) {
                $this->addFlash('warning', 'Invalid username confirmation.');
            } else {
                if (!$user->isDisabled()) {//If user IS NOT disabled
                    //If username validation succeeds
                    $user->setDisabled(true);

                    $user->setRoles(['ROLE_DISABLED']);

                    $entityManager->persist($user);
                    $this->addFlash('success', "User {$user->getUsername()} has been disabled.");
                } else {
                    //If user IS disabled
                    $user->setDisabled(false);

                    $user->setRoles(['ROLE_USER']);

                    $entityManager->persist($user);
                    $this->addFlash('success', "User {$user->getUsername()} has been re-activated.");
                }

                $entityManager->flush();
            }

            return $this->redirectToRoute('app_mod_member_editing', ['id' => $id]);
        }

        $forceInfoForm = $formFactory->createNamedBuilder('userInfoChange')
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => $user->getUsername()
                ],
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 0,
                        'minMessage' => 'Your username should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 180,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => $user->getEmail()
                ],
                'required' => false,
                'constraints' => [
                    new Email([
                        'message' => 'The email {{ value }} is not a valid email.',
                    ]),
                    new Length([
                        'min' => 0,
                        'minMessage' => 'Your email should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 180,
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'required' => false,
                'attr' => [
                    'placeholder' => '[Password]'
                ]
            ])
            ->add('submitChange', SubmitType::class, [
                'label' => 'Change info',
                'attr' => [
                    'class' => 'btn btn-danger mt-2 w-100'
                ]
            ])
            ->getForm();
        $forceInfoForm->handleRequest($request);

        if ($forceInfoForm->isSubmitted() && $forceInfoForm->isValid()) {
            $formData = $forceInfoForm->getData();
            $roles = $user->getRoles();

            //Check if selected user is admin and if the moderator has admin permissions. Otherwise they cannot change info.
            if (in_array('ROLE_ADMIN', $roles)) {
                if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                    $this->addFlash('danger', "WARNING! Insufficient permissions to change {$user->getUsername()}'s credentials.");
                    return $this->redirectToRoute('app_mod_member_editing', ['id' => $id]);
                }
            }

            if (isset($formData['username']) && strlen($formData['username']) > 1) {
                $username = $formData['username'];//Fetch username

                $foundUsername = $entityManager->getRepository(User::class)->findBy(['username' => $username]);//Search for duplicates

                if (count($foundUsername) > 0) {//Extra check to see if there are no duplicates
                    $this->addFlash('warning', 'This username already exists!');
                    return $this->redirectToRoute('app_mod_member_editing', ['id' => $id]);
                } else {
                    $user->setUsername($username);
                }
            }

            if (isset($formData['email']) && strlen($formData['email']) > 1) {
                $user->setEmail($formData['email']);
            }

            if (isset($formData['password']) && strlen($formData['password']) > 1) {
                $user->setPassword($userPasswordHasher->hashPassword(
                    $user,
                    $formData['password']
                ));
            }

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "User {$user->getUsername()}'s info has successfully been changed!");
            return $this->redirectToRoute('app_mod_member_editing', ['id' => $id]);
        }

        return $this->render('moderator/member_editing.html.twig', [
            'bannerTitle' => "TPOTDR | MODERATE {$user->getUsername()}",
            'user' => $user,
            'overrideTitleMargin' => true,
            'deactivateForm' => $userDeactivationForm,
            'disableForm' => $userDisableForm,
            'forceInfoForm' => $forceInfoForm,
        ]);
    }
}
