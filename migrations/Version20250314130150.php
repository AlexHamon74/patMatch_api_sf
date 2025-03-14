<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314130150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE correspondance (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, INDEX IDX_A562D1E7A76ED395 (user_id), INDEX IDX_A562D1E78E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE correspondance ADD CONSTRAINT FK_A562D1E7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE correspondance ADD CONSTRAINT FK_A562D1E78E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE correspondance DROP FOREIGN KEY FK_A562D1E7A76ED395');
        $this->addSql('ALTER TABLE correspondance DROP FOREIGN KEY FK_A562D1E78E962C16');
        $this->addSql('DROP TABLE correspondance');
    }
}
