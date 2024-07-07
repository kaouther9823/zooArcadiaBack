<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240707101710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (animal_id INT AUTO_INCREMENT NOT NULL, habitat_id INT DEFAULT NULL, race_id INT DEFAULT NULL, prenom VARCHAR(50) NOT NULL, etat VARCHAR(100) NOT NULL, INDEX IDX_6AAB231FAFFE2D26 (habitat_id), INDEX IDX_6AAB231F6E59D40D (race_id), PRIMARY KEY(animal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_image (animal_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_E4CEDDAB8E962C16 (animal_id), INDEX IDX_E4CEDDAB3DA5256D (image_id), PRIMARY KEY(animal_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis_veterinaire (avis_id INT AUTO_INCREMENT NOT NULL, veterinaire_id INT DEFAULT NULL, habitat_id INT DEFAULT NULL, commentaire VARCHAR(50) NOT NULL, INDEX IDX_B6302F175C80924 (veterinaire_id), INDEX IDX_B6302F17AFFE2D26 (habitat_id), PRIMARY KEY(avis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis_visiteur (avis_id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(50) NOT NULL, commentaire VARCHAR(50) NOT NULL, note INT NOT NULL, is_visible TINYINT(1) NOT NULL, PRIMARY KEY(avis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat (habitat_id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, commentaire_habitat VARCHAR(50) DEFAULT NULL, PRIMARY KEY(habitat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat_image (habitat_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_9AD7E031AFFE2D26 (habitat_id), INDEX IDX_9AD7E0313DA5256D (image_id), PRIMARY KEY(habitat_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (image_id INT AUTO_INCREMENT NOT NULL, image_data LONGBLOB NOT NULL, PRIMARY KEY(image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nouriture (nouriture_id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, description VARCHAR(100) DEFAULT NULL, PRIMARY KEY(nouriture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (race_id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(race_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_veterinaire (rapport_veterinaire_id INT AUTO_INCREMENT NOT NULL, veterinaire_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, detail VARCHAR(50) NOT NULL, INDEX IDX_CE729CDE5C80924 (veterinaire_id), INDEX IDX_CE729CDE8E962C16 (animal_id), PRIMARY KEY(rapport_veterinaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (role_id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (user_id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, INDEX IDX_1D1C63B3D60322AC (role_id), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (habitat_id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (race_id)');
        $this->addSql('ALTER TABLE animal_image ADD CONSTRAINT FK_E4CEDDAB8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (animal_id)');
        $this->addSql('ALTER TABLE animal_image ADD CONSTRAINT FK_E4CEDDAB3DA5256D FOREIGN KEY (image_id) REFERENCES image (image_id)');
        $this->addSql('ALTER TABLE avis_veterinaire ADD CONSTRAINT FK_B6302F175C80924 FOREIGN KEY (veterinaire_id) REFERENCES utilisateur (user_id)');
        $this->addSql('ALTER TABLE avis_veterinaire ADD CONSTRAINT FK_B6302F17AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (habitat_id)');
        $this->addSql('ALTER TABLE habitat_image ADD CONSTRAINT FK_9AD7E031AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (habitat_id)');
        $this->addSql('ALTER TABLE habitat_image ADD CONSTRAINT FK_9AD7E0313DA5256D FOREIGN KEY (image_id) REFERENCES image (image_id)');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD CONSTRAINT FK_CE729CDE5C80924 FOREIGN KEY (veterinaire_id) REFERENCES utilisateur (user_id)');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD CONSTRAINT FK_CE729CDE8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (animal_id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FAFFE2D26');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('ALTER TABLE animal_image DROP FOREIGN KEY FK_E4CEDDAB8E962C16');
        $this->addSql('ALTER TABLE animal_image DROP FOREIGN KEY FK_E4CEDDAB3DA5256D');
        $this->addSql('ALTER TABLE avis_veterinaire DROP FOREIGN KEY FK_B6302F175C80924');
        $this->addSql('ALTER TABLE avis_veterinaire DROP FOREIGN KEY FK_B6302F17AFFE2D26');
        $this->addSql('ALTER TABLE habitat_image DROP FOREIGN KEY FK_9AD7E031AFFE2D26');
        $this->addSql('ALTER TABLE habitat_image DROP FOREIGN KEY FK_9AD7E0313DA5256D');
        $this->addSql('ALTER TABLE rapport_veterinaire DROP FOREIGN KEY FK_CE729CDE5C80924');
        $this->addSql('ALTER TABLE rapport_veterinaire DROP FOREIGN KEY FK_CE729CDE8E962C16');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_image');
        $this->addSql('DROP TABLE avis_veterinaire');
        $this->addSql('DROP TABLE avis_visiteur');
        $this->addSql('DROP TABLE habitat');
        $this->addSql('DROP TABLE habitat_image');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE nouriture');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE rapport_veterinaire');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE utilisateur');
    }
}
