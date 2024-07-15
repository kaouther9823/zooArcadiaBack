<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710120230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE IF EXISTS habitat_image');
        $this->addSql('DROP TABLE IF EXISTS animal_image');
        $this->addSql('DROP TABLE IF EXISTS image');


        $this->addSql('CREATE TABLE animal_image (image_id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, image_data LONGBLOB NOT NULL, PRIMARY KEY(image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat_image (image_id INT AUTO_INCREMENT NOT NULL, habitat_id INT NOT NULL, image_data LONGBLOB NOT NULL, PRIMARY KEY(image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habitat_image ADD CONSTRAINT FK_9AD7E031AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (habitat_id)');
        $this->addSql('ALTER TABLE animal_image ADD CONSTRAINT FK_E4CEDDAB8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (animal_id)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (image_id INT AUTO_INCREMENT NOT NULL, image_data LONGBLOB NOT NULL, PRIMARY KEY(image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE animal_image MODIFY image_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON animal_image');
        $this->addSql('ALTER TABLE animal_image DROP image_data, CHANGE image_id image_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_E4CEDDAB3DA5256D ON animal_image (image_id)');
        $this->addSql('ALTER TABLE animal_image ADD PRIMARY KEY (image_id)');
        $this->addSql('ALTER TABLE habitat_image MODIFY image_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON habitat_image');
        $this->addSql('ALTER TABLE habitat_image DROP image_data, CHANGE image_id image_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_9AD7E0313DA5256D ON habitat_image (image_id)');
        $this->addSql('ALTER TABLE habitat_image ADD PRIMARY KEY (image_id)');

    }
}
