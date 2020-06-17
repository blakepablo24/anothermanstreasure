<?php

namespace App\Repository;

use App\Entity\FreeItemPictures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FreeItemPictures|null find($id, $lockMode = null, $lockVersion = null)
 * @method FreeItemPictures|null findOneBy(array $criteria, array $orderBy = null)
 * @method FreeItemPictures[]    findAll()
 * @method FreeItemPictures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreeItemPicturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreeItemPictures::class);
    }

    // /**
    //  * @return FreeItemPictures[] Returns an array of FreeItemPictures objects
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
    public function findOneBySomeField($value): ?FreeItemPictures
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
