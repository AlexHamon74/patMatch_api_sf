<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314134152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE espece (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, espece_image LONGTEXT NOT NULL, mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, espece_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, race_image LONGTEXT NOT NULL, description LONGTEXT NOT NULL, mis_ajour_le DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DA6FBBAF2D191E7A (espece_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAF2D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id)');
        $this->addSql('ALTER TABLE animal ADD race_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F6E59D40D ON animal (race_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAF2D191E7A');
        $this->addSql('DROP TABLE espece');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP INDEX IDX_6AAB231F6E59D40D ON animal');
        $this->addSql('ALTER TABLE animal DROP race_id');
    }
}
