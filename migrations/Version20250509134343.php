<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509134343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD autres_animaux TINYINT(1) DEFAULT NULL, ADD animaux_description VARCHAR(255) DEFAULT NULL, ADD presence_enfant TINYINT(1) DEFAULT NULL, ADD enfant_description VARCHAR(255) DEFAULT NULL, ADD animaux_preferes VARCHAR(255) DEFAULT NULL, ADD race_souhaite VARCHAR(255) DEFAULT NULL, ADD age_souhaite VARCHAR(255) DEFAULT NULL, ADD sexe_souhaite VARCHAR(255) DEFAULT NULL, ADD niveau_experience VARCHAR(255) DEFAULT NULL, DROP interet_animalier');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD interet_animalier JSON DEFAULT NULL, DROP autres_animaux, DROP animaux_description, DROP presence_enfant, DROP enfant_description, DROP animaux_preferes, DROP race_souhaite, DROP age_souhaite, DROP sexe_souhaite, DROP niveau_experience');
    }
}
