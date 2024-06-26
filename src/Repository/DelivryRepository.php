<?php

namespace App\Repository;

use App\Entity\Delivry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Delivry>
 *
 * @method Delivry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Delivry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Delivry[]    findAll()
 * @method Delivry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DelivryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delivry::class);
    }

    //    /**
    //     * @return Delivry[] Returns an array of Delivry objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Delivry
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
