<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240714150105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'insertion donnée dans la table service';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO service (service_id, nom, description, image_path) VALUES(1, 'Visites Guidées', 'Les visites guidées du zoo sont conçues pour offri', 'services/visiteGuide.jpg')");
        $this->addSql("INSERT INTO service (service_id, nom, description, image_path) VALUES(2, 'Restaurants', 'Les restaurants du zoo proposent une variété de ch', 'services/restaurant.jpg')");
        $this->addSql("INSERT INTO service (service_id, nom, description, image_path) VALUES(3, 'Aires de Pique-Nique', 'Pour ceux qui préfèrent apporter leur propre repas', 'services/air-pique-nique.jpg')");
        $this->addSql("INSERT INTO service (service_id, nom, description, image_path) VALUES(4, 'Boutiques de Souvenirs', 'Les boutiques de souvenirs du zoo proposent une la', 'services/boutique.jpg')");
        $this->addSql("INSERT INTO service (service_id, nom, description, image_path) VALUES(5, 'Parc de Jeux pour Enfants', 'Le parc de jeux pour enfants est un espace sécurisé', 'services/parc-jeux-enfants.jpg')");
        $this->addSql("INSERT INTO service (service_id, nom, description, image_path) VALUES(6, 'Evénements', 'Le zoo organise régulièrement des événements spéciaux', 'services/spectacle-dauphins.jpg')");
        $this->addSql("INSERT INTO service (service_id, nom, description, image_path) VALUES(7, 'Spectacles', 'Les spectacles du zoo mettent en avant les compéte', 'services/evenement.jpg')");
    }
    public function down(Schema $schema): void
    {
    }
}


