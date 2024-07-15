<?php

namespace App\Entity;

use App\Repository\HorraireRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorraireRepository::class)]
class Horraire
{
    #[ORM\Id]
    #[ORM\Column(length: 25)]
    private ?string $jour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTimeInterface $heure_ouverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTimeInterface $heure_fermeture = null;

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeureOuverture(): ?DateTimeInterface
    {
        return $this->heure_ouverture;
    }

    public function setHeureOuverture(DateTimeInterface $heure_ouverture): static
    {
        $this->heure_ouverture = $heure_ouverture;

        return $this;
    }

    public function getHeureFermeture(): ?DateTimeInterface
    {
        return $this->heure_fermeture;
    }

    public function setHeureFermeture(DateTimeInterface $heure_fermeture): static
    {
        $this->heure_fermeture = $heure_fermeture;

        return $this;
    }
}
