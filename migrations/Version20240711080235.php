<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711080235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insertion des données dans la table race';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO race (label) VALUES ('Lion')");
        $this->addSql("INSERT INTO race (label) VALUES ('Tigre')");
        $this->addSql("INSERT INTO race (label) VALUES ('Éléphant')");
        $this->addSql("INSERT INTO race (label) VALUES ('Girafe')");
        $this->addSql("INSERT INTO race (label) VALUES ('Zèbre')");
        $this->addSql("INSERT INTO race (label) VALUES ('Kangourou')");
        $this->addSql("INSERT INTO race (label) VALUES ('Panda')");
        $this->addSql("INSERT INTO race (label) VALUES ('Léopard')");
        $this->addSql("INSERT INTO race (label) VALUES ('Guépard')");
        $this->addSql("INSERT INTO race (label) VALUES ('Hyène')");
        $this->addSql("INSERT INTO race (label) VALUES ('Rhinocéros')");
        $this->addSql("INSERT INTO race (label) VALUES ('Hippopotame')");
        $this->addSql("INSERT INTO race (label) VALUES ('Ours')");
        $this->addSql("INSERT INTO race (label) VALUES ('Loup')");
        $this->addSql("INSERT INTO race (label) VALUES ('Renard')");
        $this->addSql("INSERT INTO race (label) VALUES ('Bison')");
        $this->addSql("INSERT INTO race (label) VALUES ('Buffle')");
        $this->addSql("INSERT INTO race (label) VALUES ('Chimpanzé')");
        $this->addSql("INSERT INTO race (label) VALUES ('Gorille')");
        $this->addSql("INSERT INTO race (label) VALUES ('Orang-outan')");
        $this->addSql("INSERT INTO race (label) VALUES ('Koala')");
        $this->addSql("INSERT INTO race (label) VALUES ('Crocodile')");
        $this->addSql("INSERT INTO race (label) VALUES ('Alligator')");
        $this->addSql("INSERT INTO race (label) VALUES ('Autruche')");
        $this->addSql("INSERT INTO race (label) VALUES ('Flamant rose')");
        $this->addSql("INSERT INTO race (label) VALUES ('Paon')");
        $this->addSql("INSERT INTO race (label) VALUES ('Pingouin')");
        $this->addSql("INSERT INTO race (label) VALUES ('Aigle')");
        $this->addSql("INSERT INTO race (label) VALUES ('Faucon')");
        $this->addSql("INSERT INTO race (label) VALUES ('Perroquet')");
        $this->addSql("INSERT INTO race (label) VALUES ('Dauphin')");
        $this->addSql("INSERT INTO race (label) VALUES ('Baleine')");
        $this->addSql("INSERT INTO race (label) VALUES ('Requin')");
        $this->addSql("INSERT INTO race (label) VALUES ('Poulpe')");
        $this->addSql("INSERT INTO race (label) VALUES ('Méduse')");
        $this->addSql("INSERT INTO race (label) VALUES ('Tortue de mer')");
        $this->addSql("INSERT INTO race (label) VALUES ('Etoile de mer')");
        $this->addSql("INSERT INTO race (label) VALUES ('Wharthog')");
        $this->addSql("INSERT INTO race (label) VALUES ('Eland')");
        $this->addSql("INSERT INTO race (label) VALUES ('Antilope')");
        $this->addSql("INSERT INTO race (label) VALUES ('Lémurien')");
        $this->addSql("INSERT INTO race (label) VALUES ('Baboon')");
        $this->addSql("INSERT INTO race (label) VALUES ('Cheetah')");



    }

    public function down(Schema $schema): void
    {
    }
}
