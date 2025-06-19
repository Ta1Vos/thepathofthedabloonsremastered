-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 12 jun 2024 om 11:28
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpotdr`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `accepted_quest`
--

DROP TABLE IF EXISTS `accepted_quest`;
CREATE TABLE `accepted_quest` (
  `id` int(11) NOT NULL,
  `quest_id` int(11) DEFAULT NULL,
  `player_id` int(11) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dialogue`
--

DROP TABLE IF EXISTS `dialogue`;
CREATE TABLE `dialogue` (
  `id` int(11) NOT NULL,
  `next_event_id` int(11) DEFAULT NULL,
  `dialogue_text` longtext NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `dialogue`
--

INSERT INTO `dialogue` (`id`, `next_event_id`, `dialogue_text`, `name`) VALUES
(1, NULL, 'Hello there dear traveler! How fortunate we cross eachother\'s path! Here are 2 dabloons as a gift! Lets hope we will meet again sometime!', 'traveler-dabloon2');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240612092709', '2024-06-12 11:28:02', 1151);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `effect`
--

DROP TABLE IF EXISTS `effect`;
CREATE TABLE `effect` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `debuff_duration` int(11) NOT NULL,
  `affected_player_property` varchar(255) DEFAULT NULL,
  `effect_value_severity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `effect`
--

INSERT INTO `effect` (`id`, `name`, `debuff_duration`, `affected_player_property`, `effect_value_severity`) VALUES
(1, 'heal 10hp', 1, NULL, 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `event_text` longtext NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `event`
--

INSERT INTO `event` (`id`, `shop_id`, `event_text`, `name`) VALUES
(1, NULL, 'You\'ve received 2 dabloons!', 'traveler1-dabloon2');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event_dialogue`
--

DROP TABLE IF EXISTS `event_dialogue`;
CREATE TABLE `event_dialogue` (
  `event_id` int(11) NOT NULL,
  `dialogue_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `event_dialogue`
--

INSERT INTO `event_dialogue` (`event_id`, `dialogue_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event_effect`
--

DROP TABLE IF EXISTS `event_effect`;
CREATE TABLE `event_effect` (
  `event_id` int(11) NOT NULL,
  `effect_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event_option`
--

DROP TABLE IF EXISTS `event_option`;
CREATE TABLE `event_option` (
  `event_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `event_option`
--

INSERT INTO `event_option` (`event_id`, `option_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event_world`
--

DROP TABLE IF EXISTS `event_world`;
CREATE TABLE `event_world` (
  `event_id` int(11) NOT NULL,
  `world_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `game_option`
--

DROP TABLE IF EXISTS `game_option`;
CREATE TABLE `game_option` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `luck_enabled` tinyint(1) NOT NULL,
  `dialogue_skips` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `inventory_slot`
--

DROP TABLE IF EXISTS `inventory_slot`;
CREATE TABLE `inventory_slot` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `effect_is_active` tinyint(1) NOT NULL,
  `debuff_severity` varchar(10) NOT NULL,
  `debuff_duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `rarity_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `is_weapon` tinyint(1) NOT NULL,
  `description` longtext NOT NULL,
  `defeat_chance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `item`
--

INSERT INTO `item` (`id`, `rarity_id`, `name`, `price`, `is_weapon`, `description`, `defeat_chance`) VALUES
(1, 1, 'Twig', 5, 1, '30% chance to fend off enemies. But seriously, it\'s literally a twig.', 30),
(2, 1, 'Sandwich', 2, 0, 'Heal 10 hp. Yummy!', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `item_effect`
--

DROP TABLE IF EXISTS `item_effect`;
CREATE TABLE `item_effect` (
  `item_id` int(11) NOT NULL,
  `effect_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `item_effect`
--

INSERT INTO `item_effect` (`item_id`, `effect_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `option`
--

DROP TABLE IF EXISTS `option`;
CREATE TABLE `option` (
  `id` int(11) NOT NULL,
  `quests_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `option`
--

INSERT INTO `option` (`id`, `quests_id`, `name`) VALUES
(1, NULL, 'continue');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `world_id` int(11) DEFAULT NULL,
  `health` int(11) NOT NULL,
  `dabloons` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `inventory_max` int(11) NOT NULL,
  `last_save` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `player_effect`
--

DROP TABLE IF EXISTS `player_effect`;
CREATE TABLE `player_effect` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `effect_id` int(11) DEFAULT NULL,
  `debuff_duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `quest`
--

DROP TABLE IF EXISTS `quest`;
CREATE TABLE `quest` (
  `id` int(11) NOT NULL,
  `rewarded_item_id` int(11) DEFAULT NULL,
  `quest_text` longtext NOT NULL,
  `dabloon_reward` int(11) NOT NULL,
  `is_completed` tinyint(1) NOT NULL,
  `single_completion` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rarity`
--

DROP TABLE IF EXISTS `rarity`;
CREATE TABLE `rarity` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `chance_in` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `rarity`
--

INSERT INTO `rarity` (`id`, `name`, `chance_in`, `priority`) VALUES
(1, 'Common', 85, 1),
(2, 'Uncommon', 65, 2),
(3, 'Rare', 75, 3),
(4, 'Unique', 70, 4),
(5, 'Legendary', 100, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shop`
--

DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `rarity_id` int(11) NOT NULL,
  `additional_luck` int(11) NOT NULL,
  `additional_price` int(11) NOT NULL,
  `item_amount` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `shop`
--

INSERT INTO `shop` (`id`, `rarity_id`, `additional_luck`, `additional_price`, `item_amount`, `name`) VALUES
(1, 1, 0, 0, 2, 'Common Shop');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shop_item`
--

DROP TABLE IF EXISTS `shop_item`;
CREATE TABLE `shop_item` (
  `shop_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `is_disabled` tinyint(1) NOT NULL,
  `deactivation_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `roles`, `password`, `is_disabled`, `deactivation_time`) VALUES
(1, 'admin', 'admin@TPOTDR.com', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$2y$13$02JQqn5emWqiI7c7a1g7yeFZi1qaaTFfH1oPOXdQkuaiDYEH8RnTS', 0, NULL),
(2, 'moderator', 'moderator@TPOTDR.com', '[\"ROLE_USER\",\"ROLE_MODERATOR\"]', '$2y$13$iLnXw0.o8Q./IuyDkaEDYe4FEmDsehwL/osphnDOZhNMJlbQOQ3yS', 0, NULL),
(3, 'test user', 'test@TPOTDR.com', '[\"ROLE_USER\"]', '$2y$13$rn7fOjy6A6yAvzsmWHe/ee/TrIRjVhk6a96fP5n6OiFgtGMWDWk/S', 0, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `world`
--

DROP TABLE IF EXISTS `world`;
CREATE TABLE `world` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `distance_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `world`
--

INSERT INTO `world` (`id`, `name`, `distance_limit`) VALUES
(1, 'The Forest', 0),
(2, 'The Village', 12),
(3, 'The Dark Forest', 12),
(4, 'Rolling Hills', 25),
(5, 'Freezing Taiga', 35),
(6, 'IceHeart Village', 40),
(7, 'BlueIce Valley', 45),
(8, 'Barren Flatlands', 55),
(9, 'Peaking Mountains', 75),
(10, 'Traveler\'s Inn.', 85),
(11, 'Point of No Return', 85),
(12, 'Ash Hills', 86),
(13, 'Temple of the Molten Dabloons', 100);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `accepted_quest`
--
ALTER TABLE `accepted_quest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C90641CA209E9EF4` (`quest_id`),
  ADD KEY `IDX_C90641CA99E6F5DF` (`player_id`);

--
-- Indexen voor tabel `dialogue`
--
ALTER TABLE `dialogue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F18A1C3949EDA465` (`next_event_id`);

--
-- Indexen voor tabel `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexen voor tabel `effect`
--
ALTER TABLE `effect`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3BAE0AA74D16C4DD` (`shop_id`);

--
-- Indexen voor tabel `event_dialogue`
--
ALTER TABLE `event_dialogue`
  ADD PRIMARY KEY (`event_id`,`dialogue_id`),
  ADD KEY `IDX_B766F5E971F7E88B` (`event_id`),
  ADD KEY `IDX_B766F5E9A6E12CBD` (`dialogue_id`);

--
-- Indexen voor tabel `event_effect`
--
ALTER TABLE `event_effect`
  ADD PRIMARY KEY (`event_id`,`effect_id`),
  ADD KEY `IDX_84F9E6A071F7E88B` (`event_id`),
  ADD KEY `IDX_84F9E6A0F5E9B83B` (`effect_id`);

--
-- Indexen voor tabel `event_option`
--
ALTER TABLE `event_option`
  ADD PRIMARY KEY (`event_id`,`option_id`),
  ADD KEY `IDX_681F77E271F7E88B` (`event_id`),
  ADD KEY `IDX_681F77E2A7C41D6F` (`option_id`);

--
-- Indexen voor tabel `event_world`
--
ALTER TABLE `event_world`
  ADD PRIMARY KEY (`event_id`,`world_id`),
  ADD KEY `IDX_7B6CA06F71F7E88B` (`event_id`),
  ADD KEY `IDX_7B6CA06F8925311C` (`world_id`);

--
-- Indexen voor tabel `game_option`
--
ALTER TABLE `game_option`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_27B3AD7899E6F5DF` (`player_id`);

--
-- Indexen voor tabel `inventory_slot`
--
ALTER TABLE `inventory_slot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E6A8EF4999E6F5DF` (`player_id`),
  ADD KEY `IDX_E6A8EF49126F525E` (`item_id`);

--
-- Indexen voor tabel `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F1B251EF3747573` (`rarity_id`);

--
-- Indexen voor tabel `item_effect`
--
ALTER TABLE `item_effect`
  ADD PRIMARY KEY (`item_id`,`effect_id`),
  ADD KEY `IDX_3099E43D126F525E` (`item_id`),
  ADD KEY `IDX_3099E43DF5E9B83B` (`effect_id`);

--
-- Indexen voor tabel `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexen voor tabel `option`
--
ALTER TABLE `option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8600B05D8115BE` (`quests_id`);

--
-- Indexen voor tabel `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_98197A65A76ED395` (`user_id`),
  ADD KEY `IDX_98197A658925311C` (`world_id`);

--
-- Indexen voor tabel `player_effect`
--
ALTER TABLE `player_effect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2960072C99E6F5DF` (`player_id`),
  ADD KEY `IDX_2960072CF5E9B83B` (`effect_id`);

--
-- Indexen voor tabel `quest`
--
ALTER TABLE `quest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4317F817843BB51E` (`rewarded_item_id`);

--
-- Indexen voor tabel `rarity`
--
ALTER TABLE `rarity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B7C0BE4662A6DC27` (`priority`);

--
-- Indexen voor tabel `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AC6A4CA2F3747573` (`rarity_id`);

--
-- Indexen voor tabel `shop_item`
--
ALTER TABLE `shop_item`
  ADD PRIMARY KEY (`shop_id`,`item_id`),
  ADD KEY `IDX_DEE9C3654D16C4DD` (`shop_id`),
  ADD KEY `IDX_DEE9C365126F525E` (`item_id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`);

--
-- Indexen voor tabel `world`
--
ALTER TABLE `world`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `accepted_quest`
--
ALTER TABLE `accepted_quest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `dialogue`
--
ALTER TABLE `dialogue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `effect`
--
ALTER TABLE `effect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `game_option`
--
ALTER TABLE `game_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `inventory_slot`
--
ALTER TABLE `inventory_slot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `option`
--
ALTER TABLE `option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `player_effect`
--
ALTER TABLE `player_effect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `quest`
--
ALTER TABLE `quest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `rarity`
--
ALTER TABLE `rarity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `world`
--
ALTER TABLE `world`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `accepted_quest`
--
ALTER TABLE `accepted_quest`
  ADD CONSTRAINT `FK_C90641CA209E9EF4` FOREIGN KEY (`quest_id`) REFERENCES `quest` (`id`),
  ADD CONSTRAINT `FK_C90641CA99E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`);

--
-- Beperkingen voor tabel `dialogue`
--
ALTER TABLE `dialogue`
  ADD CONSTRAINT `FK_F18A1C3949EDA465` FOREIGN KEY (`next_event_id`) REFERENCES `event` (`id`);

--
-- Beperkingen voor tabel `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_3BAE0AA74D16C4DD` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`);

--
-- Beperkingen voor tabel `event_dialogue`
--
ALTER TABLE `event_dialogue`
  ADD CONSTRAINT `FK_B766F5E971F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B766F5E9A6E12CBD` FOREIGN KEY (`dialogue_id`) REFERENCES `dialogue` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `event_effect`
--
ALTER TABLE `event_effect`
  ADD CONSTRAINT `FK_84F9E6A071F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_84F9E6A0F5E9B83B` FOREIGN KEY (`effect_id`) REFERENCES `effect` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `event_option`
--
ALTER TABLE `event_option`
  ADD CONSTRAINT `FK_681F77E271F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_681F77E2A7C41D6F` FOREIGN KEY (`option_id`) REFERENCES `option` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `event_world`
--
ALTER TABLE `event_world`
  ADD CONSTRAINT `FK_7B6CA06F71F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7B6CA06F8925311C` FOREIGN KEY (`world_id`) REFERENCES `world` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `game_option`
--
ALTER TABLE `game_option`
  ADD CONSTRAINT `FK_27B3AD7899E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`);

--
-- Beperkingen voor tabel `inventory_slot`
--
ALTER TABLE `inventory_slot`
  ADD CONSTRAINT `FK_E6A8EF49126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_E6A8EF4999E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`);

--
-- Beperkingen voor tabel `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_1F1B251EF3747573` FOREIGN KEY (`rarity_id`) REFERENCES `rarity` (`id`);

--
-- Beperkingen voor tabel `item_effect`
--
ALTER TABLE `item_effect`
  ADD CONSTRAINT `FK_3099E43D126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3099E43DF5E9B83B` FOREIGN KEY (`effect_id`) REFERENCES `effect` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `option`
--
ALTER TABLE `option`
  ADD CONSTRAINT `FK_5A8600B05D8115BE` FOREIGN KEY (`quests_id`) REFERENCES `quest` (`id`);

--
-- Beperkingen voor tabel `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `FK_98197A658925311C` FOREIGN KEY (`world_id`) REFERENCES `world` (`id`),
  ADD CONSTRAINT `FK_98197A65A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `player_effect`
--
ALTER TABLE `player_effect`
  ADD CONSTRAINT `FK_2960072C99E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `FK_2960072CF5E9B83B` FOREIGN KEY (`effect_id`) REFERENCES `effect` (`id`);

--
-- Beperkingen voor tabel `quest`
--
ALTER TABLE `quest`
  ADD CONSTRAINT `FK_4317F817843BB51E` FOREIGN KEY (`rewarded_item_id`) REFERENCES `item` (`id`);

--
-- Beperkingen voor tabel `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `FK_AC6A4CA2F3747573` FOREIGN KEY (`rarity_id`) REFERENCES `rarity` (`id`);

--
-- Beperkingen voor tabel `shop_item`
--
ALTER TABLE `shop_item`
  ADD CONSTRAINT `FK_DEE9C365126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DEE9C3654D16C4DD` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
