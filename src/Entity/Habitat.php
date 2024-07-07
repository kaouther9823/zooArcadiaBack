<?php

// src/Entity/Habitat.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: "App\Repository\HabitatRepository")]
class Habitat
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    #[Groups(['avis_veterinaire:read'])]
    private $habitatId;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['avis_veterinaire:read'])]
    private $nom;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['avis_veterinaire:read'])]
    private $description;

    public function getHabitatId(): ?int
    {
        return $this->habitatId;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

}
