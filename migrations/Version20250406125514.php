<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406125514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP mis_ajour_le');
        $this->addSql('ALTER TABLE espece DROP mis_ajour_le, CHANGE espece_image espece_image LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE personnalite DROP mis_ajour_le, CHANGE personnalite_image personnalite_image LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE race DROP mis_ajour_le, CHANGE race_image race_image LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race ADD mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE race_image race_image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE espece ADD mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE espece_image espece_image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnalite ADD mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE personnalite_image personnalite_image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
