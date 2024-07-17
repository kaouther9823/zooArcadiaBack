<?php

namespace App\Repository;

use App\Entity\AvisVisiteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AvisVisiteur>
 */
class AvisVisiteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvisVisiteur::class);
    }
    public function findAllOrdred(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.treated', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByVisible(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.visible = :val')
            ->setParameter('val', true)
                ->orderBy('a.avisId', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return AvisVisiteur[] Returns an array of AvisVisiteur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AvisVisiteur
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
