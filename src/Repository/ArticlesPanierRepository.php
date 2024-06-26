<?php

namespace App\Repository;

use App\Entity\ArticlesPanier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticlesPanier>
 *
 * @method ArticlesPanier|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticlesPanier|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticlesPanier[]    findAll()
 * @method ArticlesPanier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesPanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticlesPanier::class);
    }

    //    /**
    //     * @return ArticlesPanier[] Returns an array of ArticlesPanier objects
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

    //    public function findOneBySomeField($value): ?ArticlesPanier
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
