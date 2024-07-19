<?php

// src/Entity/Animal.php
namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column("animal_id", type: 'integer')]
    #[Groups(['habitat:read', 'animal:read', 'rapport_veterinaire:read', 'rapport_employe:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['habitat:read', 'animal:read', 'rapport_veterinaire:read', 'rapport_employe:read'])]
    private $prenom;

    #[ORM\ManyToOne(targetEntity: "Etat")]
    #[ORM\JoinColumn(name: "etat_id", referencedColumnName: "etat_id")]
    #[Groups(['habitat:read', 'animal:read'])]
    private $etat;

    #[ORM\ManyToOne(targetEntity: 'Habitat')]
    #[ORM\JoinColumn(name: "habitat_id", referencedColumnName: "habitat_id")]
    #[Groups(['animal:read'])]
    #[MaxDepth(1)]
    private Habitat $habitat;

    #[ORM\ManyToOne(targetEntity: "Race")]
    #[ORM\JoinColumn(name: "race_id", referencedColumnName: "race_id")]
    #[Groups(['habitat:read', 'animal:read', 'rapport_veterinaire:read', 'rapport_employe:read'git ])]
    private $race;

    /**
     * @var Collection<int, HabitatImage>
     */
    #[ORM\OneToMany(targetEntity: AnimalImage::class, mappedBy: 'animal', cascade: ['persist', 'remove'],  orphanRemoval: true)]
    #[Groups(['habitat:read'])]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getHabitat(): Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(Habitat $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }

    /**
     * @return Collection<int, AnimalImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(AnimalImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setHabitat($this);
        }

        return $this;
    }

    public function removeImage(AnimalImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getHabitat() === $this) {
                $image->setHabitat(null);
            }
        }

        return $this;
    }
}
