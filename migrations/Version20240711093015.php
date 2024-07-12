<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711093015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation table etat';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE etat (etat_id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(etat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql("INSERT INTO etat (label) VALUES ('Nouvel arrivant')");
        $this->addSql("INSERT INTO etat (label) VALUES ('Malade')");
        $this->addSql("INSERT INTO etat (label) VALUES ('Blessé')");
        $this->addSql("INSERT INTO etat (label) VALUES ('En soins')");
        $this->addSql("INSERT INTO etat (label) VALUES ('En quarantaine')");
        $this->addSql("INSERT INTO etat (label) VALUES ('En réhabilitation')");

    }
}