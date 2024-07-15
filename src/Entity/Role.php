<?php

// src/Entity/Role.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: "App\Repository\RoleRepository")]
class Role
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    #[Groups(['avis_veterinaire:read'])]
    private $roleId;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['avis_veterinaire:read'])]
    private $label;

    public function getRoleId(): ?int
    {
        return $this->roleId;
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
}
