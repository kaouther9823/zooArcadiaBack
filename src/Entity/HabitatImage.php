<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: "App\Repository\HabitatImageRepository")]
class HabitatImage
{

    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    #[Groups(['habitat:read'])]
    private $imageId;

    #[ORM\Column(type: "blob")]
    #[Groups(['habitat:read'])]
    private $imageData;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(name: "habitat_id", referencedColumnName: "habitat_id", nullable: false)]
    private ?Habitat $habitat = null;

    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    public function setImageData($imageData): static
    {
        $this->imageData = $imageData;
        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat($habitat): static
    {
        $this->habitat = $habitat;

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
}