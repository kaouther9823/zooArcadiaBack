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

    #[ORM\Column(type: "blob")]
    private $imageData;

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

    public function getImageData()
    {
        if (is_resource($this->imageData)) {
            $data = stream_get_contents($this->imageData);
        } else {
            $data = $this->imageData;
        }
        return $data;
    }

    public function getBase64Data(): ?string
    {
        $data = $this->getImageData();
        return $data !== null ? base64_encode($data) : null;
    }

    public function setImageData($imageData): static
    {
        $this->imageData = $imageData;
        return $this;
    }


}
