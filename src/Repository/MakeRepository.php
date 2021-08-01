<?php

namespace App\Repository;

use App\Entity\Make;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Make|null find($id, $lockMode = null, $lockVersion = null)
 * @method Make|null findOneBy(array $criteria, array $orderBy = null)
 * @method Make[]    findAll()
 * @method Make[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Make::class);
    }

    // /**
    //  * @return Make[] Returns an array of Make objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Make
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
