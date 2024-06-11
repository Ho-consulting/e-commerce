<?php

namespace App\Repository;

use App\Entity\StockCaracterestique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockCaracterestique>
 *
 * @method StockCaracterestique|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockCaracterestique|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockCaracterestique[]    findAll()
 * @method StockCaracterestique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockCaracterestiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockCaracterestique::class);
    }

    //    /**
    //     * @return StockCaracterestique[] Returns an array of StockCaracterestique objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?StockCaracterestique
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
