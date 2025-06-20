<?php

namespace App\Controller;

use App\Entity\Dialogue;
use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\GameOption;
use App\Entity\Item;
use App\Entity\Option;
use App\Entity\Player;
use App\Entity\Rarity;
use App\Entity\Shop;
use App\Entity\World;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

$encoders = [new JsonEncoder()];
$normalizers = [new ObjectNormalizer()];

$serializer = new Serializer($normalizers, $encoders);

class GameController extends AbstractController
{
    #[Route('/game/save-file/create', name: 'app_game_save_file_create')]
    public function saveFileCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        $players = $user->getPlayers();

        if (count($players) >= 3) {
            $this->addFlash('warning', 'You cannot have more than 3 save files. Delete one in order to create another one.');
            return $this->redirectToRoute('app_game_save_file_menu');
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
        $player->setLuck(0);
        $player->setLastSave(new \DateTime());

        $entityManager->persist($player);
        $entityManager->flush();

        return $this->redirectToRoute('app_game_save_file_menu');
    }

    #[Route('/game/save-file/load/{id}', name: 'app_game_save_file_load')]
    public function saveFileLoad(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        $players = $user->getPlayers();
        $selectedPlayer = null;

        foreach ($players as $player) {
            if ($player->getId() == $id) {
                $session = $request->getSession();
                $session->set('game-player-id', $id);
                $request->setSession($session);
                $selectedPlayer = true;
            }
        }

        if (!$selectedPlayer) {
            $this->addFlash('danger', 'Access denied (404).');
            return $this->redirectToRoute('app_home');
        }

        return $this->redirectToRoute('app_game');
    }

    #[Route('/game/save-files', name: 'app_game_save_file_menu')]
    public function saveFileMenu(Request $request, EntityManagerInterface $entityManager, int $id = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        $players = $user->getPlayers();

        return $this->render('game/save-files.html.twig', [
            'bannerTitle' => 'TPOTDR | Save File Select',
            'players' => $players,
        ]);
    }

    #[Route('/game/fetch/{gameProperty}/{id}', name: 'app_game_fetch')]
    public function fetchInfo(Request $request, EntityManagerInterface $entityManager, string $gameProperty, $id = null): Response
    {
        $playerSession = $request->getSession()->get('game-player-id');
        if (!$playerSession) {
            return new Response('ERROR: No save file selected (404)');
        }

        $player = $entityManager->getRepository(Player::class)->find($playerSession);
        $currentWorld = $player->getWorld();
        $entity = null;

        if (!$gameProperty) {
            return new Response('ERROR: Access denied (400)');
        }

        if ($gameProperty == 'start') {//Check if player meets the requirements to get the start dialogue, otherwise load a random event. !Required to start the game!
            if ($player->getDistance() <= 0) {
                $entity = $entityManager->getRepository(Event::class)->findOneBy(['name' => '!start']);
                $player->setDistance(1);
                $entityManager->persist($player);
                $entityManager->flush();
            } else {
                $gameProperty = 'random';
                $id = 'event';
            }
        }

        if ($gameProperty == 'random') {
            switch ($id) {
                case 'event':
                    $events = $currentWorld->getEvents();
                    $entity = $events[rand(0, count($events) - 1)];

                    if (!$entity) {
                        return new Response('ERROR: Something went wrong! Event (404)');
                    }

//                    dd($events, $entity);
                    break;
            }
        }

        if (!$entity) {//If entity has been selected, skip
            if (!intval($id)) {//If no id has been selected, ignore
                return new Response('ERROR: Access denied (400)');
            }

            switch ($gameProperty) {
                case 'dialogue':
                    $entity = $entityManager->getRepository(Dialogue::class)->find($id);
                    break;
                case 'event':
                    $entity = $entityManager->getRepository(Event::class)->find($id);
                    break;
                case 'option':
                    $entity = $entityManager->getRepository(Option::class)->find($id);
                    break;
                case 'item':
                    $entity = $entityManager->getRepository(Item::class)->find($id);
                    break;
                case 'effect':
                    $entity = $entityManager->getRepository(Effect::class)->find($id);
                    break;
                case 'world':
                    $entity = $entityManager->getRepository(World::class)->find($id);
                    break;
                case 'shop':
                    $entity = $entityManager->getRepository(Shop::class)->find($id);
                    break;
                case 'quest':

                    break;
            }
        }

        if (!$entity) {
            return new Response('ERROR: Access denied (404)');
        }

        $json = $entity->getJSONFormat();
//        dd($entity);
        return new Response($json);
    }

    #[Route('/game/ingame', name: 'app_game')]
    public function game(Request $request, EntityManagerInterface $entityManager): Response
    {
        $playerSession = $request->getSession()->get('game-player-id');
        if (!$playerSession) {
            $this->addFlash('warning', 'No save file selected.');
            return $this->redirectToRoute('app_home');
        }

        $player = $entityManager->getRepository(Player::class)->find($playerSession);
        return $this->render('game/index.html.twig', [
            'overrideTitleMargin' => true,
            'player' => $player,
            'statusEffects' => $player->getPlayerEffects()
        ]);
    }

    #[Route('/game/test/effect-add', name: 'app_test_effect_add')]
    public function testEffectAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = $entityManager->getRepository(Player::class)->find(1);

        $effect = $entityManager->getRepository(Effect::class)->find(1);
        $player->createPlayerEffect($effect, $entityManager);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/game/test/effect-update', name: 'app_update_effect_update')]
    public function testEffectUpdate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $playerSession = $request->getSession()->get('game-player-id');
        if (!$playerSession) {
            $this->addFlash('warning', 'No save file selected.');
            return $this->redirectToRoute('app_home');
        }

        $player = $entityManager->getRepository(Player::class)->find($playerSession);

        $player->updatePlayerEffects($entityManager);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/game/test/item-generate', name: 'app_update_item_generate')]
    public function testItemGeneration(Request $request, EntityManagerInterface $entityManager): Response
    {
        $playerSession = $request->getSession()->get('game-player-id');
        if (!$playerSession) {
            return new Response('No item selected');
        }

        $player = $entityManager->getRepository(Player::class)->find($playerSession);
        $rarity = $entityManager->getRepository(Rarity::class)->findOneBy(['name' => 'Common']);

        $newRarity = $rarity->generateRarity($player->getLuck(), $entityManager);
        $items = $newRarity->getItems();
        $item = $items[rand(0, count($items) - 1)];
//        dd($item->getJSONFormat(false));

        return new Response($item->getJSONFormat());
    }
}
