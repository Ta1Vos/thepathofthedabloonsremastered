<?php

namespace App\Controller;

use App\Entity\Dialogue;
use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Quest;
use App\Form\CreateSubmitType;
use App\Form\DialogueType;
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
            return $this->redirectToRoute('app_admin_dashboard_dialogues_create');
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
        $dialogues = $entityManager->getRepository(Dialogue::class)->findAll();

        $form = $this->createForm(DialogueType::class);
        $form->add('submit', SubmitType::class, [
            'label' => 'Create Dialogue'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully added dialogue!');
            return $this->redirectToRoute('app_admin_dashboard_dialogues');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | Dialogue Editor",
            'dialogues' => $dialogues,
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/event', name: 'app_admin_dashboard_events')]
    public function events(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $events = $entityManager->getRepository(Event::class)->findAll();
        $this->addFlash('danger', 'WARNING: COMPLETELY NEW FEATURES / EVENTS WILL HAVE TO BE IMPLEMENTED INTO THE PROJECT. CONTACT A DEVELOPER IF THAT IS THE CASE.');

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Event Editor",
            'events' => $events
        ]);
    }

    #[Route('/admin/dashboard/item', name: 'app_admin_dashboard_items')]
    public function items(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $items = $entityManager->getRepository(Item::class)->findAll();
        $this->addFlash('danger', 'WARNING: COMPLETELY NEW FEATURES / ITEMS WILL HAVE TO BE IMPLEMENTED INTO THE PROJECT. CONTACT A DEVELOPER IF THAT IS THE CASE.');

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Item Editor",
            'items' => $items
        ]);
    }

    #[Route('/admin/dashboard/effect', name: 'app_admin_dashboard_effects')]
    public function effects(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->addFlash('danger', 'WARNING: COMPLETELY NEW FEATURES / EFFECTS WILL HAVE TO BE IMPLEMENTED INTO THE PROJECT. CONTACT A DEVELOPER IF THAT IS THE CASE.');
        $effects = $entityManager->getRepository(Effect::class)->findAll();

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Effect Editor",
            'effects' => $effects
        ]);
    }

    #[Route('/admin/dashboard/quests', name: 'app_admin_dashboard_quests')]
    public function quests(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $quests = $entityManager->getRepository(Quest::class)->findAll();

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Quest Editor",
            'quests' => $quests
        ]);
    }
}
