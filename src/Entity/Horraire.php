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
    private ?DateTimeInterface $heureOuverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTimeInterface $heureFermeture = null;

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
        return $this->heureOuverture;
    }

    public function setHeureOuverture(DateTimeInterface $heureOuverture): static
    {
        $this->heureOuverture = $heureOuverture;

        return $this;
    }

    public function getHeureFermeture(): ?DateTimeInterface
    {
        return $this->heureFermeture;
    }

    public function setHeureFermeture(DateTimeInterface $heureFermeture): static
    {
        $this->heureFermeture = $heureFermeture;

        return $this;
    }

    public function getFormattedData(): array
    {
        $formattedHeureOuverture = $this->heureOuverture ? $this->heureOuverture->format('H:i') : null;
        $formattedHeureFermeture = $this->heureFermeture ? $this->heureFermeture->format('H:i') : null;

        return [
            'jour' => $this->jour,
            'heureOuverture' => $formattedHeureOuverture,
            'heureFermeture' => $formattedHeureFermeture,
        ];
    }
}
