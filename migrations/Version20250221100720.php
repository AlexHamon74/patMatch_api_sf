<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221100720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, date_de_naissance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', numero_de_telephone VARCHAR(10) DEFAULT NULL, description LONGTEXT DEFAULT NULL, adresse VARCHAR(150) DEFAULT NULL, code_postal VARCHAR(5) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, photo_profil LONGTEXT DEFAULT NULL, mis_a_jour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', interet_animalier JSON DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `user`');
    }
}
