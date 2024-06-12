<?php

namespace App\Controller;

use App\Entity\Effect;
use App\Entity\GameOption;
use App\Entity\Player;
use App\Entity\World;
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
        $user = $this->getUser();

        $players = $user->getPlayers();

        if (count($players) >= 3) {
            $this->addFlash('warning', 'You cannot have more than 3 save files. Delete one in order to create another one.');
            return $this->redirectToRoute('app_home');
        }

//        $gameOptions = new GameOption();
//        $gameOptions->setDialogueSkips(false);
//        $gameOptions->setLuckEnabled(true);

        $player = new Player();
        $world = $entityManager->getRepository(World::class)->findOneBy(['distanceLimit' => 0]);

        //Define Player variables
        $player->setUser($this->getUser());
        $player->setInventoryMax(2);
        $player->setHealth(100);
        $player->setWorld($world);
        $player->setDistance(0);
        $player->setDabloons(0);
        $player->setLastSave(new \DateTime());

        $entityManager->persist($player);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/game/ingame', name: 'app_game')]
    public function game(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('game/index.html.twig', [
            'overrideTitleMargin' => true
        ]);
    }

    #[Route('/game/test', name: 'app_testing')]
    public function test(Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = $entityManager->getRepository(Player::class)->find(2);

        $effect = $entityManager->getRepository(Effect::class)->find(4);
        $player->createPlayerEffect($effect, $entityManager);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/game/update', name: 'app_update')]
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = $entityManager->getRepository(Player::class)->find(2);

        $player->updatePlayerEffects($entityManager);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
