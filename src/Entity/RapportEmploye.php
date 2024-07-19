<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: "App\Repository\RapportEmployeRepository")]
class RapportEmploye
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column("rapport_employe_id", type: "integer")]
    #[Groups(['rapport_employe:read'])]
    private $id;

    #[ORM\Column(type: "date")]
    #[Groups(['rapport_employe:read'])]
    private $date;

    #[ORM\ManyToOne(targetEntity: "Nouriture")]
    #[ORM\JoinColumn(name: "nouriture_id", referencedColumnName: "nouriture_id")]
    #[Groups(['rapport_employe:read'])]
    private $nouriture;

    #[ORM\Column(type: "integer")]
    #[Groups(['rapport_employe:read'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: "Utilisateur")]
    #[ORM\JoinColumn(name: "employe_id", referencedColumnName: "user_id")]
    #[Groups(['rapport_employe:read'])]
    private $employe;


    #[ORM\ManyToOne(targetEntity: "Animal")]
    #[ORM\JoinColumn(name: "animal_id", referencedColumnName: "animal_id")]
    #[Groups(['rapport_employe:read'])]
    #[MaxDepth(1)]
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



    public function getAnimal(): Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): static
    {
        $this->animal = $animal;
        return $this;
    }

    public function getEmploye(): ?Utilisateur
    {
        return $this->employe;
    }

    public function setEmploye(?Utilisateur $employe): static
    {
        $this->employe = $employe;
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

    public function setNouriture(Nouriture $nouriture): static
    {
        $this->nouriture = $nouriture;

        return $this;
    }
}
