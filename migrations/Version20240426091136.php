<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426091136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accepted_quest (id INT AUTO_INCREMENT NOT NULL, quest_id INT DEFAULT NULL, player_id INT DEFAULT NULL, is_completed TINYINT(1) DEFAULT NULL, INDEX IDX_C90641CA209E9EF4 (quest_id), INDEX IDX_C90641CA99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accepted_quest ADD CONSTRAINT FK_C90641CA209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE accepted_quest ADD CONSTRAINT FK_C90641CA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE quest ADD rewarded_item_id INT DEFAULT NULL, ADD single_completion TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817843BB51E FOREIGN KEY (rewarded_item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_4317F817843BB51E ON quest (rewarded_item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accepted_quest DROP FOREIGN KEY FK_C90641CA209E9EF4');
        $this->addSql('ALTER TABLE accepted_quest DROP FOREIGN KEY FK_C90641CA99E6F5DF');
        $this->addSql('DROP TABLE accepted_quest');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817843BB51E');
        $this->addSql('DROP INDEX IDX_4317F817843BB51E ON quest');
        $this->addSql('ALTER TABLE quest DROP rewarded_item_id, DROP single_completion');
    }
}
