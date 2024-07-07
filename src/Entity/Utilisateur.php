<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: "App\Repository\UtilisateurRepository")]
class Utilisateur implements UserInterface
{

    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    #[Groups(['avis_veterinaire:read'])]
    private $userId;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['avis_veterinaire:read'])]
    private $username;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['avis_veterinaire:read'])]
    private $password;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['avis_veterinaire:read'])]
    private $nom;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['avis_veterinaire:read'])]
    private $prenom;

    #[ORM\ManyToOne(targetEntity: "Role")]
    #[ORM\JoinColumn(name: "role_id", referencedColumnName: "role_id")]
    #[Groups(['avis_veterinaire:read'])]
    private $role;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;
        return $this;
    }


    public function getRoles(): array
    {
        return array($this->role);
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
        return $this->username;
    }
}
