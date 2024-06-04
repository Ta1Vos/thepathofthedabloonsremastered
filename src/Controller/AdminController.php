<?php

namespace App\Controller;

use App\Entity\Dialogue;
use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Quest;
use App\Form\CreateSubmitType;
use App\Form\DeleteSubmitType;
use App\Form\DialogueType;
use App\Form\EffectType;
use App\Form\EventType;
use App\Form\ItemType;
use App\Form\QuestType;
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

    /*
     *  DIALOGUE CRUD
     */

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

    #[Route('/admin/dashboard/dialogue/delete/{id}', name: 'app_admin_dashboard_dialogues_delete')]
    public function dialoguesDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Dialogue';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $dialogue = $entityManager->getRepository(Dialogue::class)->find($id);

        //Check if an entity has been selected
        if (!$dialogue) {
            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $deleteBtn = $this->createForm(DeleteSubmitType::class);
        $deleteBtn->handleRequest($request);

        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
            $entityManager->remove($dialogue);
            $entityManager->flush();
            $this->addFlash('success', "Successfully deleted $dashboardType");
            return $this->redirectToRoute('app_admin_dashboard_dialogues');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $dialogue,
            'confirmBtn' => $deleteBtn,
        ]);
    }

    /*
     *  EVENT CRUD
     */

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
        $dashboardType = 'Event';

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
            return $this->redirectToRoute('app_admin_dashboard_events');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/event/delete/{id}', name: 'app_admin_dashboard_events_delete')]
    public function eventsDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Event';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $event = $entityManager->getRepository(Event::class)->find($id);

        //Check if an entity has been selected
        if (!$event) {
            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $deleteBtn = $this->createForm(DeleteSubmitType::class);
        $deleteBtn->handleRequest($request);

        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
            $entityManager->remove($event);
            $entityManager->flush();
            $this->addFlash('success', "Successfully deleted $dashboardType");
            return $this->redirectToRoute('app_admin_dashboard_dialogues');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $event,
            'confirmBtn' => $deleteBtn,
        ]);
    }

    /*
     *  ITEM CRUD
     */

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

    #[Route('/admin/dashboard/item/create', name: 'app_admin_dashboard_items_create')]
    public function itemsCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Item';

        $form = $this->createForm(ItemType::class);
        $form->add('submit', SubmitType::class, [
            'label' => "Create {$dashboardType}"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully added {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_items');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/item/delete/{id}', name: 'app_admin_dashboard_items_delete')]
    public function itemsDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Item';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $item = $entityManager->getRepository(Item::class)->find($id);

        //Check if an entity has been selected
        if (!$item) {
            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $deleteBtn = $this->createForm(DeleteSubmitType::class);
        $deleteBtn->handleRequest($request);

        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
            $entityManager->remove($item);
            $entityManager->flush();
            $this->addFlash('success', "Successfully deleted $dashboardType");
            return $this->redirectToRoute('app_admin_dashboard_dialogues');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $item,
            'confirmBtn' => $deleteBtn,
        ]);
    }

    /*
     *  EFFECT CRUD
     */

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

    #[Route('/admin/dashboard/effect/create', name: 'app_admin_dashboard_effects_create')]
    public function effectCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Effect';

        $form = $this->createForm(EffectType::class);
        $form->add('submit', SubmitType::class, [
            'label' => "Create {$dashboardType}"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully added {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_effects');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/effect/delete/{id}', name: 'app_admin_dashboard_effects_delete')]
    public function effectsDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Effect';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $effect = $entityManager->getRepository(Effect::class)->find($id);

        //Check if an entity has been selected
        if (!$effect) {
            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $deleteBtn = $this->createForm(DeleteSubmitType::class);
        $deleteBtn->handleRequest($request);

        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
            $entityManager->remove($effect);
            $entityManager->flush();
            $this->addFlash('success', "Successfully deleted $dashboardType");
            return $this->redirectToRoute('app_admin_dashboard_dialogues');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $effect,
            'confirmBtn' => $deleteBtn,
        ]);
    }

    /*
     *  QUEST CRUD
     */

    #[Route('/admin/dashboard/quests', name: 'app_admin_dashboard_quests')]
    public function quests(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_NONE');
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

    #[Route('/admin/dashboard/quest/create', name: 'app_admin_dashboard_quests_create')]
    public function questCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_NONE');
        $dashboardType = 'Quest';
        $this->addFlash('warning', 'THIS PAGE IS NOT IN USE. NOT EVERYTHING WILL WORK ACCORDINGLY');

        $form = $this->createForm(QuestType::class);
        $form->add('submit', SubmitType::class, [
            'label' => "Create {$dashboardType}"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully added {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_quests');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/quest/delete/{id}', name: 'app_admin_dashboard_quests_delete')]
    public function questsDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_NONE');
        $dashboardType = 'Quest';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $quest = $entityManager->getRepository(Quest::class)->find($id);

        //Check if an entity has been selected
        if (!$quest) {
            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $deleteBtn = $this->createForm(DeleteSubmitType::class);
        $deleteBtn->handleRequest($request);

        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
            $entityManager->remove($quest);
            $entityManager->flush();
            $this->addFlash('success', "Successfully deleted $dashboardType");
            return $this->redirectToRoute('app_admin_dashboard_dialogues');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $quest,
            'confirmBtn' => $deleteBtn,
        ]);
    }
}
