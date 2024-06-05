<?php

namespace App\Controller;

use App\Entity\GameOption;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    #[Route('/game/save-file/create', name: 'app_game_save-file_create')]
    public function saveFileCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

//        $gameOptions = new GameOption();
//        $gameOptions->setDialogueSkips(false);
//        $gameOptions->setLuckEnabled(true);

        $player = new Player();

        //Define Player variables
        $player->setUser($this->getUser());
        $player->setInventoryMax(2);
        $player->setHealth(100);
//        $player->setWorld(0);
        $player->setDistance(0);
        $player->setDabloons(0);

        $entityManager->persist($player);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
