<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240715194346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creer table horraire';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horraire (jour VARCHAR(25) NOT NULL, heure_ouverture TIME NOT NULL, heure_fermeture TIME NOT NULL, PRIMARY KEY(jour)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO arcadia_zoo_db.horraire (jour, heure_ouverture, heure_fermeture) VALUES('Lundi', '09:00:00', '18:00:00')");
        $this->addSql("INSERT INTO arcadia_zoo_db.horraire (jour, heure_ouverture, heure_fermeture) VALUES('Mardi', '09:00:00', '18:00:00')");
        $this->addSql("INSERT INTO arcadia_zoo_db.horraire (jour, heure_ouverture, heure_fermeture) VALUES('Mercredi', '09:00:00', '18:00:00'");
        $this->addSql("INSERT INTO arcadia_zoo_db.horraire (jour, heure_ouverture, heure_fermeture) VALUES('Jeudi', '09:00:00', '18:00:00')");
        $this->addSql("INSERT INTO arcadia_zoo_db.horraire (jour, heure_ouverture, heure_fermeture) VALUES('Vendredi', '09:00:00', '18:00:00')");
        $this->addSql("INSERT INTO arcadia_zoo_db.horraire (jour, heure_ouverture, heure_fermeture) VALUES('Samedi', '09:00:00', '18:00:00')");
        $this->addSql("INSERT INTO arcadia_zoo_db.horraire (jour, heure_ouverture, heure_fermeture) VALUES('Dimanche', '09:00:00', '18:00:00')");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE horraire');
    }
}
