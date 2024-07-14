<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: "App\Repository\RaceRepository")]
class Race
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column("race_id", type: "integer")]
    #[Groups(['animal:read'])]
    private $id;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['animal:read'])]
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
