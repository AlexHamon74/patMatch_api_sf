<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314131358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_personnalite (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, personnalite_id INT DEFAULT NULL, INDEX IDX_F30742E68E962C16 (animal_id), INDEX IDX_F30742E62E282BF5 (personnalite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnalite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, personnalite_image LONGTEXT DEFAULT NULL, mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_personnalite ADD CONSTRAINT FK_F30742E68E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal_personnalite ADD CONSTRAINT FK_F30742E62E282BF5 FOREIGN KEY (personnalite_id) REFERENCES personnalite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_personnalite DROP FOREIGN KEY FK_F30742E68E962C16');
        $this->addSql('ALTER TABLE animal_personnalite DROP FOREIGN KEY FK_F30742E62E282BF5');
        $this->addSql('DROP TABLE animal_personnalite');
        $this->addSql('DROP TABLE personnalite');
    }
}
