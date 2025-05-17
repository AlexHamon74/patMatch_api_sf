<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250517161624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_personnalite DROP FOREIGN KEY FK_F30742E62E282BF5');
        $this->addSql('ALTER TABLE animal_personnalite DROP FOREIGN KEY FK_F30742E68E962C16');
        $this->addSql('DROP TABLE personnalite');
        $this->addSql('DROP TABLE animal_personnalite');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FFB88E14F');
        $this->addSql('DROP INDEX IDX_6AAB231FFB88E14F ON animal');
        $this->addSql('ALTER TABLE animal ADD eleveur_id INT NOT NULL, DROP utilisateur_id');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F489D1B5F FOREIGN KEY (eleveur_id) REFERENCES eleveur (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F489D1B5F ON animal (eleveur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personnalite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, personnalite_image LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE animal_personnalite (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, personnalite_id INT DEFAULT NULL, INDEX IDX_F30742E62E282BF5 (personnalite_id), INDEX IDX_F30742E68E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE animal_personnalite ADD CONSTRAINT FK_F30742E62E282BF5 FOREIGN KEY (personnalite_id) REFERENCES personnalite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE animal_personnalite ADD CONSTRAINT FK_F30742E68E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F489D1B5F');
        $this->addSql('DROP INDEX IDX_6AAB231F489D1B5F ON animal');
        $this->addSql('ALTER TABLE animal ADD utilisateur_id INT DEFAULT NULL, DROP eleveur_id');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6AAB231FFB88E14F ON animal (utilisateur_id)');
    }
}
