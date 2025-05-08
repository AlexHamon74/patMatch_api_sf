<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250508104729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD type_logement VARCHAR(255) DEFAULT NULL, ADD espace_exterieur VARCHAR(255) DEFAULT NULL, ADD type_environnement VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP code_postal, DROP ville, DROP type_compte');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ADD code_postal VARCHAR(5) DEFAULT NULL, ADD ville VARCHAR(100) DEFAULT NULL, ADD type_compte VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client DROP type_logement, DROP espace_exterieur, DROP type_environnement');
    }
}
