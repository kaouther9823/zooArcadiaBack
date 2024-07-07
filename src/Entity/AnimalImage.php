<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\AnimalImageRepository")]
class AnimalImage
{
    #[ORM\Id()]
    #[ORM\ManyToOne(targetEntity: "Animal")]
    #[ORM\JoinColumn(name: "animal_id", referencedColumnName: "animal_id")]
    private $animal;

    #[ORM\Id()]
    #[ORM\ManyToOne(targetEntity: "Image")]
    #[ORM\JoinColumn(name: "image_id", referencedColumnName: "image_id")]
    private $image;

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;
        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }
}
