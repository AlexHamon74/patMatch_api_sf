<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250528080306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adoption (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, date_demande DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EDDEB6A919EB6921 (client_id), INDEX IDX_EDDEB6A98E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adoption ADD CONSTRAINT FK_EDDEB6A919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE adoption ADD CONSTRAINT FK_EDDEB6A98E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adoption DROP FOREIGN KEY FK_EDDEB6A919EB6921');
        $this->addSql('ALTER TABLE adoption DROP FOREIGN KEY FK_EDDEB6A98E962C16');
        $this->addSql('DROP TABLE adoption');
    }
}
