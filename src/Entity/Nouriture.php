<?php

namespace App\Entity;

use App\Repository\NouritureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: NouritureRepository::class)]
class Nouriture
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column("nouriture_id", type: "integer")]
    #[Groups(['rapport_veterinaire:read'])]
    private ?int $id;

    #[ORM\Column(length: 50)]
    #[Groups(['rapport_veterinaire:read'])]
    private ?string $label;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
