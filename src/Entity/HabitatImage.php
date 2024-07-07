<?php

// src/Entity/HabitatImage.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\HabitatImageRepository")]
class HabitatImage
{
    #[ORM\Id()]
    #[ORM\ManyToOne(targetEntity: "Habitat")]
    #[ORM\JoinColumn(name: "habitat_id", referencedColumnName: "habitat_id")]
    private $habitat;

    #[ORM\Id()]
    #[ORM\ManyToOne(targetEntity: "Image")]
    #[ORM\JoinColumn(name: "image_id", referencedColumnName: "image_id")]
    private $image;

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;
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
