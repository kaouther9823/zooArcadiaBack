<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\RapportVeterinaireRepository")]
class RapportVeterinaire
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $rapportVeterinaireId;
    #[ORM\Column(type: "date")]
    private $date;

    #[ORM\Column(type: "string", length: 50)]
    private $detail;

    #[ORM\ManyToOne(targetEntity: "Utilisateur")]
    #[ORM\JoinColumn(name: "veterinaire_id", referencedColumnName: "user_id")]
    private $veterinaire;

    #[ORM\ManyToOne(targetEntity: "Animal")]
    #[ORM\JoinColumn(name: "animal_id", referencedColumnName: "animal_id")]
    private $animal;

    public function getRapportVeterinaireId(): ?int
    {
        return $this->rapportVeterinaireId;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;
        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;
        return $this;
    }

    public function getVeterinaire(): ?Utilisateur
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?Utilisateur $veterinaire): static
    {
        $this->veterinaire = $veterinaire;
        return $this;
    }
}
