<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: "App\Repository\RapportVeterinaireRepository")]
class RapportVeterinaire
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column("rapport_veterinaire_id", type: "integer")]
    private $id;
    #[ORM\Column(type: "date")]
    #[Groups(['rapport_veterinaire'])]
    private $date;
    #[ORM\ManyToOne(targetEntity: "Nouriture")]
    #[ORM\JoinColumn(name: "nouriture_id", referencedColumnName: "nouriture_id")]
    #[Groups(['rapport_veterinaire'])]
    private $nouriture;
    #[ORM\Column(type: "integer")]
    #[Groups(['rapport_veterinaire'])]
    private $quantite;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['rapport_veterinaire'])]
    private $detail;

    #[ORM\ManyToOne(targetEntity: "Utilisateur")]
    #[ORM\JoinColumn(name: "veterinaire_id", referencedColumnName: "user_id")]
    #[Groups(['rapport_veterinaire'])]
    private $veterinaire;

    #[ORM\ManyToOne(targetEntity: "Etat")]
    #[ORM\JoinColumn(name: "etat_id", referencedColumnName: "etat_id")]
    #[Groups(['rapport_veterinaire'])]
    private $etat;
    #[ORM\ManyToOne(targetEntity: "Animal")]
    #[ORM\JoinColumn(name: "animal_id", referencedColumnName: "animal_id")]
    #[Groups(['rapport_veterinaire'])]
    private $animal;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getNouriture(): ?Nouriture
    {
        return $this->nouriture;
    }

    public function setNouriture(?Nouriture $nouriture): static
    {
        $this->nouriture = $nouriture;

        return $this;
    }
}
