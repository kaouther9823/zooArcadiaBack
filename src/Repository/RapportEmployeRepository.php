<?php

namespace App\Repository;

use App\Entity\RapportEmploye;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RapportEmploye>
 */
class RapportEmployeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RapportEmploye::class);
    }

    /**
     * @param string|null $animalName
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     * @return RapportEmploye[]
     */
    public function findReportsByCriteria(?string $animalName, ?DateTime $startDate, ?DateTime $endDate): array
    {
        $qb = $this->createQueryBuilder('r')
            ->join('r.animal', 'a');

        if ($animalName) {
            $qb->andWhere('LOWER(a.prenom) LIKE :animalName')
                ->setParameter('animalName', '%' . strtolower($animalName) . '%');
        }

        if ($startDate) {
            $qb->andWhere('r.date >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        if ($endDate) {
            $qb->andWhere('r.date <= :endDate')
                ->setParameter('endDate', $endDate);
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return RapportEmploye[] Returns an array of RapportEmploye objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RapportEmploye
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
