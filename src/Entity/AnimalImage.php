<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\AnimalImageRepository")]
class AnimalImage
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $imageId;

    #[ORM\Column(type: "blob")]
    private $imageData;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'images')]
    #[ORM\JoinColumn(name: "animal_id", referencedColumnName: "animal_id", nullable: false)]
    private ?Animal $animal = null;

    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    public function setImageData($imageData): static
    {
        $this->imageData = $imageData;
        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

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