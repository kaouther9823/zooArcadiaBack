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

    #[ORM\Column("is_visible", type: "boolean")]
    private $visible;

    #[ORM\Column("is_treated", type: "boolean")]
    private $treated;

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
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;
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

    public function isTreated(): ?bool
    {
        return $this->treated;
    }

    public function setTreated(bool $treated): static
    {
        $this->treated = $treated;
        return $this;
    }

}
