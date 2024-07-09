<?php


declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240708183016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Met à jour la taille du champ description à 500 caractères dans la table service';
    }

    public function up(Schema $schema): void
    {
        // Cette méthode contient la migration vers le haut
        $this->addSql('ALTER TABLE service MODIFY description VARCHAR(500)');
    }

    public function down(Schema $schema): void
    {
        // Cette méthode contient la migration vers le bas (rollback)
        $this->addSql('ALTER TABLE service MODIFY description VARCHAR(255)');
    }
}
