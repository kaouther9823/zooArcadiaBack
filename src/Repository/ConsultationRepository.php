<?php
// src/Repository/ConsultationRepository.php

namespace App\Repository;

use App\Document\Consultation;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class ConsultationRepository extends DocumentRepository
{
    public function __construct(DocumentManager $dm)
    {
        $uow = $dm->getUnitOfWork();
        $classMetaData = $dm->getClassMetadata(Consultation::class);
        parent::__construct($dm, $uow, $classMetaData);
    }
    public function findOneByAnimalName(string $animalName): ?Consultation
    {
        return $this->findOneBy(['animalName' => $animalName]);
    }

}
