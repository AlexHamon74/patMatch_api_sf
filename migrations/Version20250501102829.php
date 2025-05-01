<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501102829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleveur (id INT NOT NULL, nom_elevage_association VARCHAR(100) DEFAULT NULL, numero_enregistrement VARCHAR(255) DEFAULT NULL, a_propos LONGTEXT DEFAULT NULL, certificat LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eleveur ADD CONSTRAINT FK_860DE008BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD discr VARCHAR(255) NOT NULL, DROP a_propos, DROP nom_elevage_association, DROP numero_enregistrement, DROP certificat');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleveur DROP FOREIGN KEY FK_860DE008BF396750');
        $this->addSql('DROP TABLE eleveur');
        $this->addSql('ALTER TABLE `user` ADD a_propos LONGTEXT DEFAULT NULL, ADD nom_elevage_association VARCHAR(100) DEFAULT NULL, ADD numero_enregistrement VARCHAR(255) DEFAULT NULL, ADD certificat LONGTEXT DEFAULT NULL, DROP discr');
    }
}
