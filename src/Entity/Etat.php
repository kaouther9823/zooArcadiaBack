<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EtatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
//#[ApiResource]
class Etat
{
    #[ORM\Id()]
    #[ORM\GeneratedValue]
    #[ORM\Column("etat_id",type: "integer")]
    #[Groups(['animal:read', 'rapport_veterinaire:read', 'etat:read'])]
    private int $id;

    #[ORM\Column(length: 50)]
    #[Groups(['animal:read', 'rapport_veterinaire:read', 'etat:read'])]
    private $label;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
