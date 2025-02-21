<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221152233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document_administratif (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, chemin_document LONGTEXT NOT NULL, INDEX IDX_33F0D121FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document_administratif ADD CONSTRAINT FK_33F0D121FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e66b981c689 TO IDX_23A0E66FB88E14F');
        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e668a3c7387 TO IDX_23A0E66BCF5E72D');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document_administratif DROP FOREIGN KEY FK_33F0D121FB88E14F');
        $this->addSql('DROP TABLE document_administratif');
        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e66fb88e14f TO IDX_23A0E66B981C689');
        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e66bcf5e72d TO IDX_23A0E668A3C7387');
    }
}
