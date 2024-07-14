<?php

// src/Entity/Habitat.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: "App\Repository\HabitatRepository")]
class Habitat
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column("habitat_id", type: "integer")]
    #[Groups(['habitat:read', 'habitat_image:read','avis_veterinaire:read'])]
    private $id;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['habitat:read','avis_veterinaire:read'])]
    private $nom;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['habitat:read','avis_veterinaire:read'])]
    private $description;

    /**
     * @var Collection<int, HabitatImage>
     */
    #[ORM\OneToMany(targetEntity: HabitatImage::class, mappedBy: 'habitat', cascade: ['persist', 'remove'], fetch: "EAGER", orphanRemoval: true)]
    #[Groups(['habitat:read'])]
    private Collection $images;

    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'habitat', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['habitat:read'])]
    private Collection $animals;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, HabitatImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(HabitatImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setHabitat($this);
        }

        return $this;
    }

    public function removeImage(HabitatImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getHabitat() === $this) {
                $image->setHabitat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HabitatImage>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setHabitat($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getHabitat() === $this) {
                $animal->setHabitat(null);
            }
        }

        return $this;
    }
}
