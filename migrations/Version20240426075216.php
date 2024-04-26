<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426075216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_effect (event_id INT NOT NULL, effect_id INT NOT NULL, INDEX IDX_84F9E6A071F7E88B (event_id), INDEX IDX_84F9E6A0F5E9B83B (effect_id), PRIMARY KEY(event_id, effect_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_dialogue (event_id INT NOT NULL, dialogue_id INT NOT NULL, INDEX IDX_B766F5E971F7E88B (event_id), INDEX IDX_B766F5E9A6E12CBD (dialogue_id), PRIMARY KEY(event_id, dialogue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_option (event_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_681F77E271F7E88B (event_id), INDEX IDX_681F77E2A7C41D6F (option_id), PRIMARY KEY(event_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_world (event_id INT NOT NULL, world_id INT NOT NULL, INDEX IDX_7B6CA06F71F7E88B (event_id), INDEX IDX_7B6CA06F8925311C (world_id), PRIMARY KEY(event_id, world_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_effect (item_id INT NOT NULL, effect_id INT NOT NULL, INDEX IDX_3099E43D126F525E (item_id), INDEX IDX_3099E43DF5E9B83B (effect_id), PRIMARY KEY(item_id, effect_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_effect ADD CONSTRAINT FK_84F9E6A071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_effect ADD CONSTRAINT FK_84F9E6A0F5E9B83B FOREIGN KEY (effect_id) REFERENCES effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_dialogue ADD CONSTRAINT FK_B766F5E971F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_dialogue ADD CONSTRAINT FK_B766F5E9A6E12CBD FOREIGN KEY (dialogue_id) REFERENCES dialogue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_option ADD CONSTRAINT FK_681F77E271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_option ADD CONSTRAINT FK_681F77E2A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_world ADD CONSTRAINT FK_7B6CA06F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_world ADD CONSTRAINT FK_7B6CA06F8925311C FOREIGN KEY (world_id) REFERENCES world (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_effect ADD CONSTRAINT FK_3099E43D126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_effect ADD CONSTRAINT FK_3099E43DF5E9B83B FOREIGN KEY (effect_id) REFERENCES effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event DROP options');
        $this->addSql('ALTER TABLE game_option ADD player_id INT NOT NULL');
        $this->addSql('ALTER TABLE game_option ADD CONSTRAINT FK_27B3AD7899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_27B3AD7899E6F5DF ON game_option (player_id)');
        $this->addSql('ALTER TABLE inventory_slot ADD player_id INT DEFAULT NULL, ADD item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory_slot ADD CONSTRAINT FK_E6A8EF4999E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE inventory_slot ADD CONSTRAINT FK_E6A8EF49126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_E6A8EF4999E6F5DF ON inventory_slot (player_id)');
        $this->addSql('CREATE INDEX IDX_E6A8EF49126F525E ON inventory_slot (item_id)');
        $this->addSql('ALTER TABLE item ADD rarity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EF3747573 FOREIGN KEY (rarity_id) REFERENCES rarity (id)');
        $this->addSql('CREATE INDEX IDX_1F1B251EF3747573 ON item (rarity_id)');
        $this->addSql('ALTER TABLE `option` ADD quests_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B05D8115BE FOREIGN KEY (quests_id) REFERENCES quest (id)');
        $this->addSql('CREATE INDEX IDX_5A8600B05D8115BE ON `option` (quests_id)');
        $this->addSql('ALTER TABLE player ADD user_id INT DEFAULT NULL, ADD world_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A658925311C FOREIGN KEY (world_id) REFERENCES world (id)');
        $this->addSql('CREATE INDEX IDX_98197A65A76ED395 ON player (user_id)');
        $this->addSql('CREATE INDEX IDX_98197A658925311C ON player (world_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_effect DROP FOREIGN KEY FK_84F9E6A071F7E88B');
        $this->addSql('ALTER TABLE event_effect DROP FOREIGN KEY FK_84F9E6A0F5E9B83B');
        $this->addSql('ALTER TABLE event_dialogue DROP FOREIGN KEY FK_B766F5E971F7E88B');
        $this->addSql('ALTER TABLE event_dialogue DROP FOREIGN KEY FK_B766F5E9A6E12CBD');
        $this->addSql('ALTER TABLE event_option DROP FOREIGN KEY FK_681F77E271F7E88B');
        $this->addSql('ALTER TABLE event_option DROP FOREIGN KEY FK_681F77E2A7C41D6F');
        $this->addSql('ALTER TABLE event_world DROP FOREIGN KEY FK_7B6CA06F71F7E88B');
        $this->addSql('ALTER TABLE event_world DROP FOREIGN KEY FK_7B6CA06F8925311C');
        $this->addSql('ALTER TABLE item_effect DROP FOREIGN KEY FK_3099E43D126F525E');
        $this->addSql('ALTER TABLE item_effect DROP FOREIGN KEY FK_3099E43DF5E9B83B');
        $this->addSql('DROP TABLE event_effect');
        $this->addSql('DROP TABLE event_dialogue');
        $this->addSql('DROP TABLE event_option');
        $this->addSql('DROP TABLE event_world');
        $this->addSql('DROP TABLE item_effect');
        $this->addSql('ALTER TABLE event ADD options LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE game_option DROP FOREIGN KEY FK_27B3AD7899E6F5DF');
        $this->addSql('DROP INDEX UNIQ_27B3AD7899E6F5DF ON game_option');
        $this->addSql('ALTER TABLE game_option DROP player_id');
        $this->addSql('ALTER TABLE inventory_slot DROP FOREIGN KEY FK_E6A8EF4999E6F5DF');
        $this->addSql('ALTER TABLE inventory_slot DROP FOREIGN KEY FK_E6A8EF49126F525E');
        $this->addSql('DROP INDEX IDX_E6A8EF4999E6F5DF ON inventory_slot');
        $this->addSql('DROP INDEX IDX_E6A8EF49126F525E ON inventory_slot');
        $this->addSql('ALTER TABLE inventory_slot DROP player_id, DROP item_id');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EF3747573');
        $this->addSql('DROP INDEX IDX_1F1B251EF3747573 ON item');
        $this->addSql('ALTER TABLE item DROP rarity_id');
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B05D8115BE');
        $this->addSql('DROP INDEX IDX_5A8600B05D8115BE ON `option`');
        $this->addSql('ALTER TABLE `option` DROP quests_id');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65A76ED395');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A658925311C');
        $this->addSql('DROP INDEX IDX_98197A65A76ED395 ON player');
        $this->addSql('DROP INDEX IDX_98197A658925311C ON player');
        $this->addSql('ALTER TABLE player DROP user_id, DROP world_id');
        $this->addSql('ALTER TABLE `user` RENAME INDEX uniq_identifier_email TO UNIQ_8D93D649E7927C74');
    }
}
