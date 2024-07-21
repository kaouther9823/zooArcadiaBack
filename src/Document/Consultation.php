<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Attribute\Groups;

#[MongoDB\Document]
class Consultation
{
    #[MongoDB\Id]
    #[Groups(['consultation:read'])]
    private $id;

    #[MongoDB\Field(type: "string")]
    #[Groups(['consultation:read'])]
    private $animalName;

    #[MongoDB\Field(type: "string")]
    #[Groups(['consultation:read'])]
    private $animalRace;

    #[MongoDB\Field(type: "string")]
    #[Groups(['consultation:read'])]
    private $animalHabitat;

    #[MongoDB\Field(type: "int")]
    #[Groups(['consultation:read'])]
    private $count = 0;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAnimalName()
    {
        return $this->animalName;
    }

    /**
     * @param mixed $animalName
     */
    public function setAnimalName($animalName): void
    {
        $this->animalName = $animalName;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getAnimalRace()
    {
        return $this->animalRace;
    }

    /**
     * @param mixed $animalRace
     */
    public function setAnimalRace($animalRace): void
    {
        $this->animalRace = $animalRace;
    }

    /**
     * @return mixed
     */
    public function getAnimalHabitat()
    {
        return $this->animalHabitat;
    }

    /**
     * @param mixed $animalHabitat
     */
    public function setAnimalHabitat($animalHabitat): void
    {
        $this->animalHabitat = $animalHabitat;
    }


}