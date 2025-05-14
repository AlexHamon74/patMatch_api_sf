<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514204625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD statut_vaccination VARCHAR(100) NOT NULL, ADD statut_sterilisation VARCHAR(100) NOT NULL, ADD type_alimentation VARCHAR(100) NOT NULL, ADD type_alimentation_details LONGTEXT DEFAULT NULL, ADD niveau_energie VARCHAR(255) NOT NULL, ADD sociabilite VARCHAR(100) NOT NULL, ADD education VARCHAR(100) NOT NULL, ADD type_logement VARCHAR(100) NOT NULL, ADD famille_ideale VARCHAR(100) NOT NULL, CHANGE description histoire LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD description LONGTEXT DEFAULT NULL, DROP histoire, DROP statut_vaccination, DROP statut_sterilisation, DROP type_alimentation, DROP type_alimentation_details, DROP niveau_energie, DROP sociabilite, DROP education, DROP type_logement, DROP famille_ideale');
    }
}
