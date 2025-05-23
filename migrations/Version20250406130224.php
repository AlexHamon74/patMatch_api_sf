<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406130224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE espece CHANGE espece_image espece_image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnalite CHANGE personnalite_image personnalite_image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE race CHANGE race_image race_image LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race CHANGE race_image race_image LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE personnalite CHANGE personnalite_image personnalite_image LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE espece CHANGE espece_image espece_image LONGTEXT NOT NULL');
    }
}
