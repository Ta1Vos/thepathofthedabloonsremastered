<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528105753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE item DROP debuff_severity, DROP debuff_duration');
        $this->addSql('ALTER TABLE user ADD is_disabled TINYINT(1) NOT NULL, ADD deactivation_time DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP name');
        $this->addSql('ALTER TABLE item ADD debuff_severity VARCHAR(10) DEFAULT NULL, ADD debuff_duration INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` DROP is_disabled, DROP deactivation_time');
    }
}
