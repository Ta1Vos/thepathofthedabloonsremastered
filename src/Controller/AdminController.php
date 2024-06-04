<?php

namespace App\Controller;

use App\Entity\Dialogue;
use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Quest;
use App\Form\CreateSubmitType;
use App\Form\DialogueType;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_USER")]
class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function dashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/dashboard.html.twig', [
            'bannerTitle' => "TPOTDR | Creator Dashboard "
        ]);
    }

    #[Route('/admin/dashboard/dialogue', name: 'app_admin_dashboard_dialogues')]
    public function dialogues(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dialogues = $entityManager->getRepository(Dialogue::class)->findAll();

        $createBtn = $this->createForm(CreateSubmitType::class);
        $createBtn->handleRequest($request);

        if ($createBtn->isSubmitted() && $createBtn->isValid()) {
            return $this->redirectToRoute('app_admin_dashboard_'. 'dialogues' .'_create');
        }

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Dialogue Editor",
            'dashboardItems' => $dialogues,
            'createBtn' => $createBtn,
        ]);
    }

    #[Route('/admin/dashboard/dialogue/create', name: 'app_admin_dashboard_dialogues_create')]
    public function dialoguesCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Dialogue';

        $form = $this->createForm(DialogueType::class);
        $form->add('submit', SubmitType::class, [
            'label' => "Create {$dashboardType}"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully added {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_dialogues');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/event', name: 'app_admin_dashboard_events')]
    public function events(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $events = $entityManager->getRepository(Event::class)->findAll();
        $this->addFlash('danger', 'WARNING: COMPLETELY NEW FEATURES / EVENTS WILL HAVE TO BE IMPLEMENTED INTO THE PROJECT. CONTACT A DEVELOPER IF THAT IS THE CASE.');

        $createBtn = $this->createForm(CreateSubmitType::class);
        $createBtn->handleRequest($request);

        if ($createBtn->isSubmitted() && $createBtn->isValid()) {
            return $this->redirectToRoute('app_admin_dashboard_'. 'events' .'_create');
        }

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Event Editor",
            'dashboardItems' => $events,
            'createBtn' => $createBtn,
        ]);
    }

    #[Route('/admin/dashboard/event/create', name: 'app_admin_dashboard_events_create')]
    public function eventsCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'events';

        $form = $this->createForm(EventType::class);
        $form->add('submit', SubmitType::class, [
            'label' => "Create {$dashboardType}"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully added {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_' . $dashboardType);
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/item', name: 'app_admin_dashboard_items')]
    public function items(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $items = $entityManager->getRepository(Item::class)->findAll();
        $this->addFlash('danger', 'WARNING: COMPLETELY NEW FEATURES / ITEMS WILL HAVE TO BE IMPLEMENTED INTO THE PROJECT. CONTACT A DEVELOPER IF THAT IS THE CASE.');

        $createBtn = $this->createForm(CreateSubmitType::class);
        $createBtn->handleRequest($request);

        if ($createBtn->isSubmitted() && $createBtn->isValid()) {
            return $this->redirectToRoute('app_admin_dashboard_'. 'items' .'_create');
        }

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Item Editor",
            'dashboardItems' => $items,
            'createBtn' => $createBtn,
        ]);
    }

    #[Route('/admin/dashboard/effect', name: 'app_admin_dashboard_effects')]
    public function effects(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->addFlash('danger', 'WARNING: COMPLETELY NEW FEATURES / EFFECTS WILL HAVE TO BE IMPLEMENTED INTO THE PROJECT. CONTACT A DEVELOPER IF THAT IS THE CASE.');
        $effects = $entityManager->getRepository(Effect::class)->findAll();

        $createBtn = $this->createForm(CreateSubmitType::class);
        $createBtn->handleRequest($request);

        if ($createBtn->isSubmitted() && $createBtn->isValid()) {
            return $this->redirectToRoute('app_admin_dashboard_'. 'effects' .'_create');
        }

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Effect Editor",
            'dashboardItems' => $effects,
            'createBtn' => $createBtn,
        ]);
    }

    #[Route('/admin/dashboard/quests', name: 'app_admin_dashboard_quests')]
    public function quests(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $quests = $entityManager->getRepository(Quest::class)->findAll();

        $createBtn = $this->createForm(CreateSubmitType::class);
        $createBtn->handleRequest($request);

        if ($createBtn->isSubmitted() && $createBtn->isValid()) {
            return $this->redirectToRoute('app_admin_dashboard_'. 'quests' .'_create');
        }

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Quest Editor",
            'dashboardItems' => $quests,
            'createBtn' => $createBtn,
        ]);
    }
}
