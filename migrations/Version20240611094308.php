<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611094308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_changes (id INT AUTO_INCREMENT NOT NULL, player_property VARCHAR(255) DEFAULT NULL, change_value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_changes_effect (property_changes_id INT NOT NULL, effect_id INT NOT NULL, INDEX IDX_C74978C5E8219798 (property_changes_id), INDEX IDX_C74978C5F5E9B83B (effect_id), PRIMARY KEY(property_changes_id, effect_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_changes_effect ADD CONSTRAINT FK_C74978C5E8219798 FOREIGN KEY (property_changes_id) REFERENCES property_changes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_changes_effect ADD CONSTRAINT FK_C74978C5F5E9B83B FOREIGN KEY (effect_id) REFERENCES effect (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B7C0BE4662A6DC27 ON rarity (priority)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property_changes_effect DROP FOREIGN KEY FK_C74978C5E8219798');
        $this->addSql('ALTER TABLE property_changes_effect DROP FOREIGN KEY FK_C74978C5F5E9B83B');
        $this->addSql('DROP TABLE property_changes');
        $this->addSql('DROP TABLE property_changes_effect');
        $this->addSql('DROP INDEX UNIQ_B7C0BE4662A6DC27 ON rarity');
    }
}
