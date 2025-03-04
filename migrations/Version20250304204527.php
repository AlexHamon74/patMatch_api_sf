<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304204527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, date_de_naissance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', couleur VARCHAR(100) NOT NULL, numero_identification INT NOT NULL, poids INT NOT NULL, taille INT NOT NULL, sexe VARCHAR(255) NOT NULL, infos_sante LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, animal_image LONGTEXT DEFAULT NULL, mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6AAB231FFB88E14F (utilisateur_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (numero_identification), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FFB88E14F');
        $this->addSql('DROP TABLE animal');
    }
}
