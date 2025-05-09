<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509161755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleveur ADD adresse_elevage VARCHAR(255) DEFAULT NULL, ADD annee_creation VARCHAR(255) DEFAULT NULL, ADD espece_proposee VARCHAR(255) DEFAULT NULL, ADD horaire_ouverture VARCHAR(255) DEFAULT NULL, ADD condition_adoption VARCHAR(255) DEFAULT NULL, ADD suivi_post_adoption TINYINT(1) DEFAULT NULL, ADD suivi_post_adoption_duree VARCHAR(255) DEFAULT NULL, CHANGE a_propos presentation LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleveur DROP adresse_elevage, DROP annee_creation, DROP espece_proposee, DROP horaire_ouverture, DROP condition_adoption, DROP suivi_post_adoption, DROP suivi_post_adoption_duree, CHANGE presentation a_propos LONGTEXT DEFAULT NULL');
    }
}
