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
        $player->setLuck(0);
        $player->setLastSave(new \DateTime());

        $entityManager->persist($player);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/game/save-file/load/{id}', name: 'app_game_save-file_load')]
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

    #[Route('/game/fetch/{gameProperty}/{id}', name: 'app_game_fetch')]
    public function fetchInfo(Request $request, EntityManagerInterface $entityManager, string $gameProperty, $id = null): Response
    {
        $playerSession = $request->getSession()->get('game-player-id');
        if (!$playerSession) {
            return new Response('No save file selected (404)');
        }

        $player = $entityManager->getRepository(Player::class)->find($playerSession);
        $currentWorld = $player->getWorld();
        $entity = null;

        if (!$gameProperty) {
            $this->addFlash('danger', 'Access denied (400) 1.');
            return $this->redirectToRoute('app_home');
        }

        if ($gameProperty == 'random') {
            switch ($id) {
                case 'event':
                    $events = $currentWorld->getEvents();
                    $entity = $events[rand(0, count($events) - 1)];
//                    dd($events);
                    break;
            }
        }

        if (!intval($id) && !$entity) {
            $this->addFlash('warning', 'Access denied (400) 2.');
            return $this->redirectToRoute('app_home');
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

        if (!$entity) {
            $this->addFlash('danger', 'Access denied (404).');
            return $this->redirectToRoute('app_home');
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
            'overrideTitleMargin' => true
        ]);
    }

    #[Route('/game/test/effect-add', name: 'app_test_effect_add')]
    public function testEffectAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = $entityManager->getRepository(Player::class)->find(2);

        $effect = $entityManager->getRepository(Effect::class)->find(4);
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
