<?php

namespace App\Repository;

use App\Entity\FreeItemConversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FreeItemConversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method FreeItemConversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method FreeItemConversation[]    findAll()
 * @method FreeItemConversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreeItemConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreeItemConversation::class);
    }

    // /**
    //  * @return FreeItemConversation[] Returns an array of FreeItemConversation objects
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
    public function findOneBySomeField($value): ?FreeItemConversation
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
