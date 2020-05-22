<?php

namespace App\Repository;

use App\Entity\FreeItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FreeItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method FreeItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method FreeItem[]    findAll()
 * @method FreeItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreeItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreeItem::class);
    }

    // /**
    //  * @return FreeItem[] Returns an array of FreeItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FreeItem
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
