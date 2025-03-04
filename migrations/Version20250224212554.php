<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224212554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, titre VARCHAR(100) NOT NULL, contenu LONGTEXT NOT NULL, date_de_creation DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', article_image LONGTEXT DEFAULT NULL, mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_23A0E66FB88E14F (utilisateur_id), INDEX IDX_23A0E66BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, categorie_image LONGTEXT DEFAULT NULL, mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `documentAdministratif` (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, chemin_document LONGTEXT NOT NULL, INDEX IDX_509F7D87FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, date_de_naissance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', numero_de_telephone VARCHAR(10) DEFAULT NULL, description LONGTEXT DEFAULT NULL, adresse VARCHAR(150) DEFAULT NULL, code_postal VARCHAR(5) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, photo_profil LONGTEXT DEFAULT NULL, mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', interet_animalier JSON DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE `documentAdministratif` ADD CONSTRAINT FK_509F7D87FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FB88E14F');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BCF5E72D');
        $this->addSql('ALTER TABLE `documentAdministratif` DROP FOREIGN KEY FK_509F7D87FB88E14F');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE `documentAdministratif`');
        $this->addSql('DROP TABLE `user`');
    }
}
