<?php

namespace App\Controller;

use App\Entity\Dialogue;
use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Option;
use App\Entity\Quest;
use App\Entity\Rarity;
use App\Entity\Shop;
use App\Entity\World;
use App\Form\CreateSubmitType;
use App\Form\DeleteSubmitType;
use App\Form\DialogueType;
use App\Form\EffectType;
use App\Form\EventType;
use App\Form\ItemType;
use App\Form\OptionType;
use App\Form\QuestType;
use App\Form\RarityType;
use App\Form\WorldType;
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

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Dialogue Editor",
            'dashboardItems' => $dialogues,
            'deleteName' => 'app_admin_dashboard_dialogues_delete',
            'editName' => 'app_admin_dashboard_dialogues_edit',
            'createName' => 'app_admin_dashboard_dialogues_create'
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

    #[Route('/admin/dashboard/dialogue/edit/{id}', name: 'app_admin_dashboard_dialogues_edit')]
    public function dialoguesEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Dialogue';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $dialogue = $entityManager->getRepository(Dialogue::class)->find($id);

        //Check if an entity has been selected
        if (!$dialogue) {
            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(DialogueType::class, $dialogue);
        $form->add('submit', SubmitType::class, [
            'label' => "Edit $dashboardType"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited {$dashboardType}!");
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

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Event Editor",
            'dashboardItems' => $events,
            'deleteName' => 'app_admin_dashboard_events_delete',
            'editName' => 'app_admin_dashboard_events_edit',
            'createName' => 'app_admin_dashboard_events_create'
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

    #[Route('/admin/dashboard/event/edit/{id}', name: 'app_admin_dashboard_events_edit')]
    public function eventsEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Event';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $event = $entityManager->getRepository(Event::class)->find($id);

        //Check if an entity has been selected
        if (!$event) {
            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(EventType::class, $event);
        $form->add('submit', SubmitType::class, [
            'label' => "Edit $dashboardType"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited {$dashboardType}!");
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
            return $this->redirectToRoute('app_admin_dashboard_events');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $event,
            'confirmBtn' => $deleteBtn,
        ]);
    }

    /*
     * OPTION CRUD
     */

    #[Route('/admin/dashboard/option', name: 'app_admin_dashboard_options')]
    public function options(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Option';
        $options = $entityManager->getRepository(Option::class)->findAll();

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItems' => $options,
            'deleteName' => 'app_admin_dashboard_options_delete',
            'editName' => 'app_admin_dashboard_options_edit',
            'createName' => 'app_admin_dashboard_options_create'
        ]);
    }

    #[Route('/admin/dashboard/option/create', name: 'app_admin_dashboard_options_create')]
    public function optionsCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Option';

        $form = $this->createForm(OptionType::class);
        $form->add('submit', SubmitType::class, [
            'label' => "Create {$dashboardType}"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully added {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_options');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/option/edit/{id}', name: 'app_admin_dashboard_options_edit')]
    public function optionsEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Option';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $option = $entityManager->getRepository(Option::class)->find($id);

        //Check if an entity has been selected
        if (!$option) {
            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(OptionType::class, $option);
        $form->add('submit', SubmitType::class, [
            'label' => "Edit $dashboardType"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_options');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/option/delete/{id}', name: 'app_admin_dashboard_options_delete')]
    public function optionsDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Option';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $option = $entityManager->getRepository(Option::class)->find($id);

        //Check if an entity has been selected
        if (!$option) {
            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $deleteBtn = $this->createForm(DeleteSubmitType::class);
        $deleteBtn->handleRequest($request);

        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
            $entityManager->remove($option);
            $entityManager->flush();
            $this->addFlash('success', "Successfully deleted $dashboardType");
            return $this->redirectToRoute('app_admin_dashboard_options');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $option,
            'confirmBtn' => $deleteBtn,
        ]);
    }

    /*
     * WORLD CRUD
     */

    #[Route('/admin/dashboard/world', name: 'app_admin_dashboard_worlds')]
    public function worlds(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'World';
        $options = $entityManager->getRepository(World::class)->findAll();

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItems' => $options,
            'deleteName' => 'app_admin_dashboard_worlds_delete',
            'editName' => 'app_admin_dashboard_worlds_edit',
            'createName' => 'app_admin_dashboard_worlds_create'
        ]);
    }

    #[Route('/admin/dashboard/world/create', name: 'app_admin_dashboard_worlds_create')]
    public function worldsCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'World';

        $form = $this->createForm(WorldType::class);
        $form->add('submit', SubmitType::class, [
            'label' => "Create {$dashboardType}"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully added {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_worlds');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/world/edit/{id}', name: 'app_admin_dashboard_worlds_edit')]
    public function worldsEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'World';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $world = $entityManager->getRepository(World::class)->find($id);

        //Check if an entity has been selected
        if (!$world) {
            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(WorldType::class, $world);
        $form->add('submit', SubmitType::class, [
            'label' => "Edit $dashboardType"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_worlds');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/world/delete/{id}', name: 'app_admin_dashboard_worlds_delete')]
    public function worldsDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'World';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $world = $entityManager->getRepository(World::class)->find($id);

        //Check if an entity has been selected
        if (!$world) {
            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $deleteBtn = $this->createForm(DeleteSubmitType::class);
        $deleteBtn->handleRequest($request);

        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
            $entityManager->remove($world);
            $entityManager->flush();
            $this->addFlash('success', "Successfully deleted $dashboardType");
            return $this->redirectToRoute('app_admin_dashboard_worlds');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $world,
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

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Item Editor",
            'dashboardItems' => $items,
            'deleteName' => 'app_admin_dashboard_items_delete',
            'editName' => 'app_admin_dashboard_items_edit',
            'createName' => 'app_admin_dashboard_items_create'
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

    #[Route('/admin/dashboard/item/edit/{id}', name: 'app_admin_dashboard_items_edit')]
    public function itemsEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Item';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $item = $entityManager->getRepository(Item::class)->find($id);

        //Check if an entity has been selected
        if (!$item) {
            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(ItemType::class, $item);
        $form->add('submit', SubmitType::class, [
            'label' => "Edit $dashboardType"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited {$dashboardType}!");
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
            return $this->redirectToRoute('app_admin_dashboard_items');
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

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Effect Editor",
            'dashboardItems' => $effects,
            'deleteName' => 'app_admin_dashboard_effects_delete',
            'editName' => 'app_admin_dashboard_effects_edit',
            'createName' => 'app_admin_dashboard_effects_create'
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

    #[Route('/admin/dashboard/effect/edit/{id}', name: 'app_admin_dashboard_effects_edit')]
    public function effectsEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Effect';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $effect = $entityManager->getRepository(Effect::class)->find($id);

        //Check if an entity has been selected
        if (!$effect) {
            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(EffectType::class, $effect);
        $form->add('submit', SubmitType::class, [
            'label' => "Edit $dashboardType"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited {$dashboardType}!");
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
            return $this->redirectToRoute('app_admin_dashboard_effects');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $effect,
            'confirmBtn' => $deleteBtn,
        ]);
    }

    /*
     * RARITY CRUD
     */

    #[Route('/admin/dashboard/rarity', name: 'app_admin_dashboard_rarities')]
    public function rarity(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Rarity';
        $options = $entityManager->getRepository(Rarity::class)->findAll();

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItems' => $options,
            'deleteName' => 'app_admin_dashboard_rarities_delete',
            'editName' => 'app_admin_dashboard_rarities_edit',
            'createName' => 'app_admin_dashboard_rarities_create'
        ]);
    }

    #[Route('/admin/dashboard/rarity/create', name: 'app_admin_dashboard_rarities_create')]
    public function rarityCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Rarity';

        $form = $this->createForm(RarityType::class);
        $form->add('submit', SubmitType::class, [
            'label' => "Create {$dashboardType}"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully added {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_rarities');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/rarity/edit/{id}', name: 'app_admin_dashboard_rarities_edit')]
    public function raritiesEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Rarity';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $rarity = $entityManager->getRepository(Rarity::class)->find($id);

        //Check if an entity has been selected
        if (!$rarity) {
            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $chanceIn = $rarity->getChanceIn();

        $form = $this->createForm(RarityType::class, $rarity);
        $form->remove('chanceIn');
        $form->add('chanceIn', null, [
            'label' => "Chance in ($chanceIn in 100) ($chanceIn%)"
        ]);
        $form->add('submit', SubmitType::class, [
            'label' => "Edit $dashboardType"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited {$dashboardType}!");
            return $this->redirectToRoute('app_admin_dashboard_rarities');
        }

        return $this->render('admin/create.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/rarity/delete/{id}', name: 'app_admin_dashboard_rarities_delete')]
    public function raritiesDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Rarity';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $rarity = $entityManager->getRepository(Rarity::class)->find($id);

        //Check if an entity has been selected
        if (!$rarity) {
            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $deleteBtn = $this->createForm(DeleteSubmitType::class);
        $deleteBtn->handleRequest($request);

        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
            $entityManager->remove($rarity);
            $entityManager->flush();
            $this->addFlash('success', "Successfully deleted $dashboardType");
            return $this->redirectToRoute('app_admin_dashboard_rarities');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $rarity,
            'confirmBtn' => $deleteBtn,
        ]);
    }

    /*
     * SHOP CRUD
     */

//    #[Route('/admin/dashboard/shops', name: 'app_admin_dashboard_shops')]
//    public function shops(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//        $shops = $entityManager->getRepository(Shop::class)->findAll();
//
//        return $this->render('admin/read.html.twig', [
//            'bannerTitle' => "TPOTDR | Quest Editor",
//            'dashboardItems' => $shops,
//            'deleteName' => '',
//            'editName' => '',
//            'createName' => ''
//        ]);
//    }
//
//    #[Route('/admin/dashboard/shop/create', name: 'app_admin_dashboard_shops_create')]
//    public function shopsCreate(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//        $dashboardType = 'Shop';
//
//        $form = $this->createForm(ShopType::class);
//        $form->add('submit', SubmitType::class, [
//            'label' => "Create {$dashboardType}"
//        ]);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $formData = $form->getData();
//            $entityManager->persist($formData);
//            $entityManager->flush();
//            $this->addFlash('success', "Successfully added {$dashboardType}!");
//            return $this->redirectToRoute('app_admin_dashboard_quests');
//        }
//
//        return $this->render('admin/create.html.twig', [
//            'bannerTitle' => "TPOTDR | $dashboardType Editor",
//            'form' => $form,
//        ]);
//    }
//
//    #[Route('/admin/dashboard/shop/edit/{id}', name: 'app_admin_dashboard_shops_edit')]
//    public function shopsEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
//    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//        $dashboardType = 'Shop';
//
//        //Check if an id has been selected
//        if (!$id) {
//            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
//            return $this->redirectToRoute('app_admin_dashboard');
//        }
//
//        $shop = $entityManager->getRepository(Shop::class)->find($id);
//
//        //Check if an entity has been selected
//        if (!$quest) {
//            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
//            return $this->redirectToRoute('app_admin_dashboard');
//        }
//
//        $form = $this->createForm(QuestType::class, $shop);
//        $form->add('submit', SubmitType::class, [
//            'label' => "Edit $dashboardType"
//        ]);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $formData = $form->getData();
//            $entityManager->persist($formData);
//            $entityManager->flush();
//            $this->addFlash('success', "Successfully edited {$dashboardType}!");
//            return $this->redirectToRoute('app_admin_dashboard_quests');
//        }
//
//        return $this->render('admin/create.html.twig', [
//            'bannerTitle' => "TPOTDR | $dashboardType Editor",
//            'form' => $form,
//        ]);
//    }
//
//    #[Route('/admin/dashboard/quest/delete/{id}', name: 'app_admin_dashboard_quests_delete')]
//    public function questsDelete(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
//    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//        $dashboardType = 'Quest';
//
//        //Check if an id has been selected
//        if (!$id) {
//            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before deleting.");
//            return $this->redirectToRoute('app_admin_dashboard');
//        }
//
//        $quest = $entityManager->getRepository(Quest::class)->find($id);
//
//        //Check if an entity has been selected
//        if (!$quest) {
//            $this->addFlash('warning', "Please select an existing $dashboardType before deleting.");
//            return $this->redirectToRoute('app_admin_dashboard');
//        }
//
//        $deleteBtn = $this->createForm(DeleteSubmitType::class);
//        $deleteBtn->handleRequest($request);
//
//        if ($deleteBtn->isSubmitted() && $deleteBtn->isValid()) {
//            $entityManager->remove($quest);
//            $entityManager->flush();
//            $this->addFlash('success', "Successfully deleted $dashboardType");
//            return $this->redirectToRoute('app_admin_dashboard_quests');
//        }
//
//        return $this->render('admin/delete.html.twig', [
//            'bannerTitle' => "TPOTDR | $dashboardType Editor",
//            'dashboardItem' => $quest,
//            'confirmBtn' => $deleteBtn,
//        ]);
//    }

    /*
     *  QUEST CRUD
     */

    #[Route('/admin/dashboard/quests', name: 'app_admin_dashboard_quests')]
    public function quests(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $quests = $entityManager->getRepository(Quest::class)->findAll();

        return $this->render('admin/read.html.twig', [
            'bannerTitle' => "TPOTDR | Quest Editor",
            'dashboardItems' => $quests,
            'deleteName' => 'app_admin_dashboard_quests_delete',
            'editName' => 'app_admin_dashboard_quests_edit',
            'createName' => 'app_admin_dashboard_quests_create'
        ]);
    }

    #[Route('/admin/dashboard/quest/create', name: 'app_admin_dashboard_quests_create')]
    public function questCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
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

    #[Route('/admin/dashboard/quest/edit/{id}', name: 'app_admin_dashboard_quests_edit')]
    public function questsEdit(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dashboardType = 'Quest';

        //Check if an id has been selected
        if (!$id) {
            $this->addFlash('warning', "Please select a valid $dashboardType identifier (ID) before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $quest = $entityManager->getRepository(Quest::class)->find($id);

        //Check if an entity has been selected
        if (!$quest) {
            $this->addFlash('warning', "Please select an existing $dashboardType before editing.");
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(QuestType::class, $quest);
        $form->add('submit', SubmitType::class, [
            'label' => "Edit $dashboardType"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();
            $this->addFlash('success', "Successfully edited {$dashboardType}!");
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
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
            return $this->redirectToRoute('app_admin_dashboard_quests');
        }

        return $this->render('admin/delete.html.twig', [
            'bannerTitle' => "TPOTDR | $dashboardType Editor",
            'dashboardItem' => $quest,
            'confirmBtn' => $deleteBtn,
        ]);
    }
}
