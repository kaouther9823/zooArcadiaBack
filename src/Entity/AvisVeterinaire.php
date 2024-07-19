<?php

// src/Entity/AvisVeterinaire.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: "App\Repository\AvisVeterinaireRepository")]
class AvisVeterinaire
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    #[Groups(['avis_veterinaire:read'])]
    private $avisId;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['avis_veterinaire:read'])]
    private $commentaire;

    #[ORM\ManyToOne(targetEntity: "Utilisateur")]
    #[ORM\JoinColumn(name: "veterinaire_id", referencedColumnName: "user_id")]
    #[Groups(['avis_veterinaire:read'])]
    private $veterinaire;

    #[ORM\ManyToOne(targetEntity: "Habitat")]
    #[ORM\JoinColumn(name: "habitat_id", referencedColumnName: "habitat_id")]
    #[Groups(['avis_veterinaire:read'])]
    private $habitat;


    #[ORM\Column(type: "date")]
    #[Groups(['avis_veterinaire:read'])]
    private $date;

    public function getAvisId(): ?int
    {
        return $this->avisId;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

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

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;
        return $this;
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


}
