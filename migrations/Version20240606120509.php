<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240606120509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accepted_quest (id INT AUTO_INCREMENT NOT NULL, quest_id INT DEFAULT NULL, player_id INT DEFAULT NULL, is_completed TINYINT(1) DEFAULT NULL, INDEX IDX_C90641CA209E9EF4 (quest_id), INDEX IDX_C90641CA99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dialogue (id INT AUTO_INCREMENT NOT NULL, next_event_id INT DEFAULT NULL, dialogue_text LONGTEXT NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_F18A1C3949EDA465 (next_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE effect (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, debuff_severity VARCHAR(10) NOT NULL, debuff_duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, shop_id INT DEFAULT NULL, event_text LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA74D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_effect (event_id INT NOT NULL, effect_id INT NOT NULL, INDEX IDX_84F9E6A071F7E88B (event_id), INDEX IDX_84F9E6A0F5E9B83B (effect_id), PRIMARY KEY(event_id, effect_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_dialogue (event_id INT NOT NULL, dialogue_id INT NOT NULL, INDEX IDX_B766F5E971F7E88B (event_id), INDEX IDX_B766F5E9A6E12CBD (dialogue_id), PRIMARY KEY(event_id, dialogue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_option (event_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_681F77E271F7E88B (event_id), INDEX IDX_681F77E2A7C41D6F (option_id), PRIMARY KEY(event_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_world (event_id INT NOT NULL, world_id INT NOT NULL, INDEX IDX_7B6CA06F71F7E88B (event_id), INDEX IDX_7B6CA06F8925311C (world_id), PRIMARY KEY(event_id, world_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_option (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, luck_enabled TINYINT(1) NOT NULL, dialogue_skips TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_27B3AD7899E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_slot (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, item_id INT DEFAULT NULL, effect_is_active TINYINT(1) NOT NULL, debuff_severity VARCHAR(10) NOT NULL, debuff_duration INT NOT NULL, INDEX IDX_E6A8EF4999E6F5DF (player_id), INDEX IDX_E6A8EF49126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, rarity_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, price INT DEFAULT NULL, is_weapon TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, defeat_chance INT DEFAULT NULL, INDEX IDX_1F1B251EF3747573 (rarity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_effect (item_id INT NOT NULL, effect_id INT NOT NULL, INDEX IDX_3099E43D126F525E (item_id), INDEX IDX_3099E43DF5E9B83B (effect_id), PRIMARY KEY(item_id, effect_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, quests_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5A8600B05D8115BE (quests_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, world_id INT DEFAULT NULL, health INT NOT NULL, dabloons INT NOT NULL, distance INT NOT NULL, inventory_max INT NOT NULL, last_save DATETIME NOT NULL, INDEX IDX_98197A65A76ED395 (user_id), INDEX IDX_98197A658925311C (world_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_effect (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, effect_id INT DEFAULT NULL, debuff_duration INT NOT NULL, INDEX IDX_2960072C99E6F5DF (player_id), INDEX IDX_2960072CF5E9B83B (effect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest (id INT AUTO_INCREMENT NOT NULL, rewarded_item_id INT DEFAULT NULL, quest_text LONGTEXT NOT NULL, dabloon_reward INT NOT NULL, is_completed TINYINT(1) NOT NULL, single_completion TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_4317F817843BB51E (rewarded_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rarity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, chance_in INT NOT NULL, priority INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, rarity_id INT NOT NULL, additional_luck INT NOT NULL, additional_price INT NOT NULL, item_amount INT NOT NULL, INDEX IDX_AC6A4CA2F3747573 (rarity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item (shop_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_DEE9C3654D16C4DD (shop_id), INDEX IDX_DEE9C365126F525E (item_id), PRIMARY KEY(shop_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_disabled TINYINT(1) NOT NULL, deactivation_time DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE world (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, distance_limit INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accepted_quest ADD CONSTRAINT FK_C90641CA209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE accepted_quest ADD CONSTRAINT FK_C90641CA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE dialogue ADD CONSTRAINT FK_F18A1C3949EDA465 FOREIGN KEY (next_event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE event_effect ADD CONSTRAINT FK_84F9E6A071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_effect ADD CONSTRAINT FK_84F9E6A0F5E9B83B FOREIGN KEY (effect_id) REFERENCES effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_dialogue ADD CONSTRAINT FK_B766F5E971F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_dialogue ADD CONSTRAINT FK_B766F5E9A6E12CBD FOREIGN KEY (dialogue_id) REFERENCES dialogue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_option ADD CONSTRAINT FK_681F77E271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_option ADD CONSTRAINT FK_681F77E2A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_world ADD CONSTRAINT FK_7B6CA06F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_world ADD CONSTRAINT FK_7B6CA06F8925311C FOREIGN KEY (world_id) REFERENCES world (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_option ADD CONSTRAINT FK_27B3AD7899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE inventory_slot ADD CONSTRAINT FK_E6A8EF4999E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE inventory_slot ADD CONSTRAINT FK_E6A8EF49126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EF3747573 FOREIGN KEY (rarity_id) REFERENCES rarity (id)');
        $this->addSql('ALTER TABLE item_effect ADD CONSTRAINT FK_3099E43D126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_effect ADD CONSTRAINT FK_3099E43DF5E9B83B FOREIGN KEY (effect_id) REFERENCES effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B05D8115BE FOREIGN KEY (quests_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A658925311C FOREIGN KEY (world_id) REFERENCES world (id)');
        $this->addSql('ALTER TABLE player_effect ADD CONSTRAINT FK_2960072C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE player_effect ADD CONSTRAINT FK_2960072CF5E9B83B FOREIGN KEY (effect_id) REFERENCES effect (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817843BB51E FOREIGN KEY (rewarded_item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2F3747573 FOREIGN KEY (rarity_id) REFERENCES rarity (id)');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C3654D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C365126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accepted_quest DROP FOREIGN KEY FK_C90641CA209E9EF4');
        $this->addSql('ALTER TABLE accepted_quest DROP FOREIGN KEY FK_C90641CA99E6F5DF');
        $this->addSql('ALTER TABLE dialogue DROP FOREIGN KEY FK_F18A1C3949EDA465');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA74D16C4DD');
        $this->addSql('ALTER TABLE event_effect DROP FOREIGN KEY FK_84F9E6A071F7E88B');
        $this->addSql('ALTER TABLE event_effect DROP FOREIGN KEY FK_84F9E6A0F5E9B83B');
        $this->addSql('ALTER TABLE event_dialogue DROP FOREIGN KEY FK_B766F5E971F7E88B');
        $this->addSql('ALTER TABLE event_dialogue DROP FOREIGN KEY FK_B766F5E9A6E12CBD');
        $this->addSql('ALTER TABLE event_option DROP FOREIGN KEY FK_681F77E271F7E88B');
        $this->addSql('ALTER TABLE event_option DROP FOREIGN KEY FK_681F77E2A7C41D6F');
        $this->addSql('ALTER TABLE event_world DROP FOREIGN KEY FK_7B6CA06F71F7E88B');
        $this->addSql('ALTER TABLE event_world DROP FOREIGN KEY FK_7B6CA06F8925311C');
        $this->addSql('ALTER TABLE game_option DROP FOREIGN KEY FK_27B3AD7899E6F5DF');
        $this->addSql('ALTER TABLE inventory_slot DROP FOREIGN KEY FK_E6A8EF4999E6F5DF');
        $this->addSql('ALTER TABLE inventory_slot DROP FOREIGN KEY FK_E6A8EF49126F525E');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EF3747573');
        $this->addSql('ALTER TABLE item_effect DROP FOREIGN KEY FK_3099E43D126F525E');
        $this->addSql('ALTER TABLE item_effect DROP FOREIGN KEY FK_3099E43DF5E9B83B');
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B05D8115BE');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65A76ED395');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A658925311C');
        $this->addSql('ALTER TABLE player_effect DROP FOREIGN KEY FK_2960072C99E6F5DF');
        $this->addSql('ALTER TABLE player_effect DROP FOREIGN KEY FK_2960072CF5E9B83B');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817843BB51E');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2F3747573');
        $this->addSql('ALTER TABLE shop_item DROP FOREIGN KEY FK_DEE9C3654D16C4DD');
        $this->addSql('ALTER TABLE shop_item DROP FOREIGN KEY FK_DEE9C365126F525E');
        $this->addSql('DROP TABLE accepted_quest');
        $this->addSql('DROP TABLE dialogue');
        $this->addSql('DROP TABLE effect');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_effect');
        $this->addSql('DROP TABLE event_dialogue');
        $this->addSql('DROP TABLE event_option');
        $this->addSql('DROP TABLE event_world');
        $this->addSql('DROP TABLE game_option');
        $this->addSql('DROP TABLE inventory_slot');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_effect');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_effect');
        $this->addSql('DROP TABLE quest');
        $this->addSql('DROP TABLE rarity');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shop_item');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE world');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
