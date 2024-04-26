<?php

namespace App\Controller;

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
    public function dialogues(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/dialogues.html.twig', [
            'bannerTitle' => "TPOTDR | Dialogue Editor"
        ]);
    }

    #[Route('/admin/dashboard/event', name: 'app_admin_dashboard_events')]
    public function events(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/events.html.twig', [
            'bannerTitle' => "TPOTDR | Event Editor"
        ]);
    }

    #[Route('/admin/dashboard/item', name: 'app_admin_dashboard_items')]
    public function items(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/items.html.twig', [
            'bannerTitle' => "TPOTDR | Item Editor"
        ]);
    }

    #[Route('/admin/dashboard/effect', name: 'app_admin_dashboard_effects')]
    public function effects(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/effects.html.twig', [
            'bannerTitle' => "TPOTDR | Effect Editor"
        ]);
    }

    #[Route('/admin/dashboard/quests', name: 'app_admin_dashboard_quests')]
    public function quests(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/quests.html.twig', [
            'bannerTitle' => "TPOTDR | Quest Editor"
        ]);
    }
}
