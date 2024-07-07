<?php

// src/Entity/Animal.php
namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $animalId;

    #[ORM\Column(type: 'string', length: 50)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 100)]
    private $etat;

    #[ORM\ManyToOne(targetEntity: 'Habitat')]
    #[ORM\JoinColumn(name: "habitat_id", referencedColumnName: "habitat_id")]
    private $habitat;

    #[ORM\ManyToOne(targetEntity: "Race")]
    #[ORM\JoinColumn(name: "race_id", referencedColumnName: "race_id")]
    private $race;

    public function getAnimalId(): ?int
    {
        return $this->animalId;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }
}
