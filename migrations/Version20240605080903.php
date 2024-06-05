<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605080903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP debuff_severity, DROP debuff_duration');
        $this->addSql('ALTER TABLE quest ADD name VARCHAR(255) NOT NULL, CHANGE is_completed is_completed TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item ADD debuff_severity VARCHAR(10) DEFAULT NULL, ADD debuff_duration INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quest DROP name, CHANGE is_completed is_completed TINYINT(1) DEFAULT NULL');
    }
}
