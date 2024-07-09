<?php

// src/Entity/Service.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: "App\Repository\ServiceRepository")]
class Service
{

    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $serviceId;

    #[ORM\Column(type: "string", length: 50)]
    private $nom;


    #[ORM\Column(type: "string", length: 50)]
    private $description;

    #[ORM\Column(length: 100)]
    private ?string $image_path = null;

    public function getServiceId(): ?int
    {
        return $this->serviceId;
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

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(string $image_path): static
    {
        $this->image_path = $image_path;

        return $this;
    }
}
