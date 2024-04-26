<?php

namespace App\Controller;

use App\Entity\Dialogue;
use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Quest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function dialogues(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $dialogues = $entityManager->getRepository(Dialogue::class)->findAll();

        return $this->render('admin/dialogues.html.twig', [
            'bannerTitle' => "TPOTDR | Dialogue Editor"
        ]);
    }

    #[Route('/admin/dashboard/event', name: 'app_admin_dashboard_events')]
    public function events(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $events = $entityManager->getRepository(Event::class)->findAll();

        return $this->render('admin/events.html.twig', [
            'bannerTitle' => "TPOTDR | Event Editor"
        ]);
    }

    #[Route('/admin/dashboard/item', name: 'app_admin_dashboard_items')]
    public function items(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $items = $entityManager->getRepository(Item::class)->findAll();

        return $this->render('admin/items.html.twig', [
            'bannerTitle' => "TPOTDR | Item Editor"
        ]);
    }

    #[Route('/admin/dashboard/effect', name: 'app_admin_dashboard_effects')]
    public function effects(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $effects = $entityManager->getRepository(Effect::class)->findAll();

        return $this->render('admin/effects.html.twig', [
            'bannerTitle' => "TPOTDR | Effect Editor"
        ]);
    }

    #[Route('/admin/dashboard/quests', name: 'app_admin_dashboard_quests')]
    public function quests(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $quests = $entityManager->getRepository(Quest::class)->findAll();

        return $this->render('admin/quests.html.twig', [
            'bannerTitle' => "TPOTDR | Quest Editor"
        ]);
    }
}
