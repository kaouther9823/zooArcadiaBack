<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713221531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'insertion donnée dans la table etat';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO role (role_id, label) VALUES (1, 'Administrateur')");
        $this->addSql("INSERT INTO role (role_id, label) VALUES (2, 'Employe')");
        $this->addSql("INSERT INTO role (role_id, label) VALUES (3, 'Veterinaire')");
        $this->addSql("INSERT INTO etat (etat_id, label) VALUES (7, 'En bonne santé')");
    }
    public function down(Schema $schema): void
    {
    }
    }