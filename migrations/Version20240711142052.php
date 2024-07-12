<?php


declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240711142052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Met à jour de la table animal';
    }

    public function up(Schema $schema): void
    {
        // Cette méthode contient la migration vers le haut
        $this->addSql('ALTER TABLE animal DROP COLUMN etat');
        $this->addSql('ALTER TABLE animal ADD etat_id integer');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_7AOB231R6E59D80D FOREIGN KEY (etat_id) REFERENCES etat (etat_id)');
    }
    public function down(Schema $schema): void
    {
        // Cette méthode contient la migration vers le bas (rollback)
        $this->addSql('ALTER TABLE animal ADD etat VARCHAR(50)');
        $this->addSql('ALTER TABLE animal DROP COLUMN etat_id');
        $this->addSql('ALTER TABLE animal_image DROP FOREIGN KEY FK_7AOB231R6E59D80D');
    }
}
