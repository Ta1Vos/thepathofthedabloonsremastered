<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610113623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player_effect (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, effect_id INT DEFAULT NULL, debuff_duration INT NOT NULL, INDEX IDX_2960072C99E6F5DF (player_id), INDEX IDX_2960072CF5E9B83B (effect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, rarity_id INT NOT NULL, additional_luck INT NOT NULL, additional_price INT NOT NULL, item_amount INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AC6A4CA2F3747573 (rarity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item (shop_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_DEE9C3654D16C4DD (shop_id), INDEX IDX_DEE9C365126F525E (item_id), PRIMARY KEY(shop_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player_effect ADD CONSTRAINT FK_2960072C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE player_effect ADD CONSTRAINT FK_2960072CF5E9B83B FOREIGN KEY (effect_id) REFERENCES effect (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2F3747573 FOREIGN KEY (rarity_id) REFERENCES rarity (id)');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C3654D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C365126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dialogue ADD next_event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dialogue ADD CONSTRAINT FK_F18A1C3949EDA465 FOREIGN KEY (next_event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_F18A1C3949EDA465 ON dialogue (next_event_id)');
        $this->addSql('ALTER TABLE effect DROP debuffs');
        $this->addSql('ALTER TABLE event ADD shop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA74D16C4DD ON event (shop_id)');
        $this->addSql('ALTER TABLE item DROP debuff_severity, CHANGE debuff_duration defeat_chance INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quest ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rarity ADD priority INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA74D16C4DD');
        $this->addSql('ALTER TABLE player_effect DROP FOREIGN KEY FK_2960072C99E6F5DF');
        $this->addSql('ALTER TABLE player_effect DROP FOREIGN KEY FK_2960072CF5E9B83B');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2F3747573');
        $this->addSql('ALTER TABLE shop_item DROP FOREIGN KEY FK_DEE9C3654D16C4DD');
        $this->addSql('ALTER TABLE shop_item DROP FOREIGN KEY FK_DEE9C365126F525E');
        $this->addSql('DROP TABLE player_effect');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shop_item');
        $this->addSql('ALTER TABLE dialogue DROP FOREIGN KEY FK_F18A1C3949EDA465');
        $this->addSql('DROP INDEX IDX_F18A1C3949EDA465 ON dialogue');
        $this->addSql('ALTER TABLE dialogue DROP next_event_id');
        $this->addSql('ALTER TABLE effect ADD debuffs LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('DROP INDEX IDX_3BAE0AA74D16C4DD ON event');
        $this->addSql('ALTER TABLE event DROP shop_id');
        $this->addSql('ALTER TABLE item ADD debuff_severity VARCHAR(10) DEFAULT NULL, CHANGE defeat_chance debuff_duration INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quest DROP name');
        $this->addSql('ALTER TABLE rarity DROP priority');
    }
}
