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

    /**
    * @return FreeItems[]
    */
    public function findSearchResultsWithLocation($data, $location)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.title LIKE :data')
            ->andWhere('f.location = :location')
            ->setParameter('data', '%'.$data.'%')
            ->setParameter('location', $location)
            ->orderBy('f.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return FreeItems[]
    */
    public function findFreeItemsInLocation($location)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.location = :location')
            ->setParameter('location', $location)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return FreeItems[]
    */
    public function findSearchResults($data)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.title LIKE :data')
            ->setParameter('data', '%'.$data.'%')
            ->orderBy('f.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
