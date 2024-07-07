<?php

// src/Entity/Image.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: "App\Repository\ImageRepository")]
class Image
{

    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $imageId;

    #[ORM\Column(type: "blob")]
    private $imageData;

    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    public function getImageData()
    {
        return $this->imageData;
    }

    public function setImageData($imageData): static
    {
        $this->imageData = $imageData;
        return $this;
    }
}
