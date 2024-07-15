<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713201633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'insertion donnée dans la table etat';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (1, 'Pommes', 'Fruits frais pour les herbivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (2, 'Carottes', 'Légumes riches en vitamines pour les herbivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (3, 'Viande', 'Viande rouge pour les carnivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (4, 'Poisson', 'Poisson frais pour les carnivores et omnivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (5, 'Graines', 'Mélange de graines pour les oiseaux et les rongeurs.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (6, 'Feuilles', 'Feuilles et branches pour les animaux herbivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (7, 'Insectes', 'Insectes variés pour les animaux insectivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (8, 'Herbe', 'Herbe fraîche pour les herbivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (9, 'Fruits Exotiques', 'Fruits exotiques pour les animaux tropicaux.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (10, 'Nectar', 'Nectar pour les oiseaux nectarivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (11, 'Légumes', 'Légumes variés pour une alimentation équilibrée.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (12, 'Œufs', 'Œufs pour les omnivores et certains carnivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (13, 'Croquettes', 'Croquettes équilibrées pour les carnivores domestiques.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (14, 'Aliments composés', 'Aliments spécialement composés pour animaux de zoo.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (15, 'Nourriture aquatique', 'Nourriture pour les animaux aquatiques.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (16, 'Miel', 'Miel pour les ours et les autres animaux.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (17, 'Lait', 'Lait pour les jeunes mammifères.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (18, 'Bambou', 'Bambou pour les pandas et autres herbivores.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (19, 'Alfalfa', 'Alfalfa pour les ruminants.')");
        $this->addSql("INSERT INTO nouriture (nouriture_id, label, description) VALUES (20, 'Foin', 'Foin pour les herbivores de grande taille.')");
    }
    public function down(Schema $schema): void
    {
    }
    }