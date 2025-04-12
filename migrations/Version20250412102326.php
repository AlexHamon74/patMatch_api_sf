<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250412102326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD type_compte VARCHAR(255) DEFAULT NULL, ADD nom_elevage_association VARCHAR(100) DEFAULT NULL, ADD numero_enregistrement VARCHAR(255) DEFAULT NULL, ADD certificat LONGTEXT DEFAULT NULL, CHANGE description a_propos LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ADD description LONGTEXT DEFAULT NULL, DROP type_compte, DROP nom_elevage_association, DROP numero_enregistrement, DROP a_propos, DROP certificat');
    }
}
