<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250524101103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE swipe DROP FOREIGN KEY FK_DB59E9A9A76ED395');
        $this->addSql('DROP INDEX IDX_DB59E9A9A76ED395 ON swipe');
        $this->addSql('ALTER TABLE swipe DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE swipe ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DB59E9A9A76ED395 ON swipe (user_id)');
    }
}
