<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713232625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE rapport_veterinaire ADD quantite INT');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD nouriture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD CONSTRAINT FK_NO745CDED5E86RE FOREIGN KEY (nouriture_id) REFERENCES nouriture (nouriture_id)');
        $this->addSql('CREATE INDEX IDX_NO745CDED5E86RE ON rapport_veterinaire (nouriture_id)');
    }

    public function down(Schema $schema): void
    {
    }
}
