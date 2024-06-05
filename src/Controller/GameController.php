<?php

namespace App\Controller;

use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    #[Route('/game/save-file/create', name: 'app_game_save-file_create')]
    public function saveFileCreate(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $player = new Player();

        

        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
