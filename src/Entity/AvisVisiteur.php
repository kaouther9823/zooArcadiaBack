<?php

// src/Entity/AvisVisiteur.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: "App\Repository\AvisVisiteurRepository")]
class AvisVisiteur
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $avisId;

    #[ORM\Column(type: "string", length: 50)]
    private $pseudo;

    #[ORM\Column(type: "string", length: 50)]
    private $commentaire;

    #[ORM\Column(type: "integer", length: 1)]
    private $note;

    #[ORM\Column(type: "boolean")]
    private $isVisible;

    public function getAvisId(): ?int
    {
        return $this->avisId;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;
        return $this;
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

    public function isVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setVisible(bool $isVisible): static
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;
        return $this;
    }
}
