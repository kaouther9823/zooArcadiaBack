<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720024603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('CREATE TABLE rapport_employe (rapport_employe_id INT AUTO_INCREMENT NOT NULL, nouriture_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, quantite INT NOT NULL, INDEX IDX_83D4B3DA2D29C56E (nouriture_id), INDEX IDX_83D4B3DA1B65292 (employe_id), INDEX IDX_83D4B3DA8E962C16 (animal_id), PRIMARY KEY(rapport_employe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rapport_employe ADD CONSTRAINT FK_83D4B3DA2D29C56E FOREIGN KEY (nouriture_id) REFERENCES nouriture (nouriture_id)');
        $this->addSql('ALTER TABLE rapport_employe ADD CONSTRAINT FK_83D4B3DA1B65292 FOREIGN KEY (employe_id) REFERENCES utilisateur (user_id)');
        $this->addSql('ALTER TABLE rapport_employe ADD CONSTRAINT FK_83D4B3DA8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (animal_id)');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE animal RENAME INDEX fk_7aob231r6e59d80d TO IDX_6AAB231FD5E86FF');
        $this->addSql('ALTER TABLE animal_image RENAME INDEX fk_e4ceddab8e962c16 TO IDX_E4CEDDAB8E962C16');
        $this->addSql('ALTER TABLE avis_veterinaire ADD date DATE NOT NULL');
        $this->addSql('ALTER TABLE avis_visiteur CHANGE is_treated is_treated TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE habitat_image RENAME INDEX fk_9ad7e031affe2d26 TO IDX_9AD7E031AFFE2D26');
        $this->addSql('ALTER TABLE rapport_veterinaire CHANGE quantite quantite INT NOT NULL');
        $this->addSql('ALTER TABLE rapport_veterinaire RENAME INDEX idx_no745cded5e86re TO IDX_CE729CDE2D29C56E');
        $this->addSql('ALTER TABLE service ADD image_data LONGBLOB NOT NULL, DROP image_path, CHANGE description description VARCHAR(500) NOT NULL');
        $this->addSql('DROP INDEX IDX_1D1C63B3D60322AC ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD roles JSON NOT NULL, DROP role_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role (role_id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rapport_employe DROP FOREIGN KEY FK_83D4B3DA2D29C56E');
        $this->addSql('ALTER TABLE rapport_employe DROP FOREIGN KEY FK_83D4B3DA1B65292');
        $this->addSql('ALTER TABLE rapport_employe DROP FOREIGN KEY FK_83D4B3DA8E962C16');
        $this->addSql('DROP TABLE rapport_employe');
        $this->addSql('ALTER TABLE animal RENAME INDEX idx_6aab231fd5e86ff TO FK_7AOB231R6E59D80D');
        $this->addSql('ALTER TABLE utilisateur ADD role_id INT DEFAULT NULL, DROP roles');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (role_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1D1C63B3D60322AC ON utilisateur (role_id)');
        $this->addSql('ALTER TABLE service ADD image_path VARCHAR(100) NOT NULL, DROP image_data, CHANGE description description VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE animal_image RENAME INDEX idx_e4ceddab8e962c16 TO FK_E4CEDDAB8E962C16');
        $this->addSql('ALTER TABLE avis_veterinaire DROP date');
        $this->addSql('ALTER TABLE avis_visiteur CHANGE is_treated is_treated TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE rapport_veterinaire CHANGE quantite quantite INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_veterinaire RENAME INDEX idx_ce729cde2d29c56e TO IDX_NO745CDED5E86RE');
        $this->addSql('ALTER TABLE habitat_image RENAME INDEX idx_9ad7e031affe2d26 TO FK_9AD7E031AFFE2D26');
        $this->addSql('ALTER TABLE arcadia_zoo_db.avis_visiteur MODIFY COLUMN commentaire varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL');
    }
}
