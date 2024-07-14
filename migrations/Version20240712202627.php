<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240712202627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal CHANGE prenom prenom VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE etat CHANGE label label VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE race CHANGE label label VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD etat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD CONSTRAINT FK_CE729CDED5E86FF FOREIGN KEY (etat_id) REFERENCES etat (etat_id)');
        $this->addSql('CREATE INDEX IDX_CE729CDED5E86FF ON rapport_veterinaire (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FD5E86FF');
        $this->addSql('ALTER TABLE animal CHANGE prenom prenom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_6aab231fd5e86ff ON animal');
        $this->addSql('CREATE INDEX FK_7AOB231R6E59D80D ON animal (etat_id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FD5E86FF FOREIGN KEY (etat_id) REFERENCES etat (etat_id)');
        $this->addSql('ALTER TABLE etat CHANGE label label VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE race CHANGE label label VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE rapport_veterinaire DROP FOREIGN KEY FK_CE729CDED5E86FF');
        $this->addSql('DROP INDEX IDX_CE729CDED5E86FF ON rapport_veterinaire');
        $this->addSql('ALTER TABLE rapport_veterinaire DROP etat_id');
        //$this->addSql('ALTER TABLE utilisateur MODIFY user_id INT NOT NULL');
        //$this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        //$this->addSql('DROP INDEX IDX_1D1C63B3D60322AC ON utilisateur');
        //$this->addSql('DROP INDEX `primary` ON utilisateur');
        //$this->addSql('ALTER TABLE utilisateur CHANGE username username VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
