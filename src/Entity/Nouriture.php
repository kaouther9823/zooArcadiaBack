<?php

namespace App\Entity;

use App\Repository\NouritureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NouritureRepository::class)]
class Nouriture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $nouriture_id;

    #[ORM\Column(length: 50)]
    private ?string $label;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNouritureId(): ?int
    {
        return $this->nouriture_id;
    }

    public function setNouritureId(int $nouriture_id): static
    {
        $this->nouriture_id = $nouriture_id;

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
