<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240715002625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "update table avis_visiteur";
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE avis_visiteur ADD is_treated TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
    }
}
