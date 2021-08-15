<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    /**
    * @return Annonce[] Returns an array of Annonce objects
   *
   */

    public function findAllByUserSelection($make =false, $model=false, $fuelType=false, $kilometers=false, $circulationYear=false, $price=false)
    {
        $parameters = new ArrayCollection();
        $qb = $this->createQueryBuilder('a');

        if($make)
        {
            $qb->andWhere('a.make = :make');
            $parameters->add(new Parameter('make', $make));
        }
        if($model)
        {
            $qb->andWhere('a.model = :model');
            $parameters->add(new Parameter('model', $model));
        }
        if($fuelType)
        {
            $qb->andWhere('a.fuelType = :fuelType');
            $parameters->add(new Parameter('fuelType', $fuelType));
        }
        if($kilometers)
        {
            $qb->andWhere('a.kilometers >= :kilometersMin');
            $parameters->add(new Parameter('kilometersMin', $kilometers[0]));
            $qb->andWhere('a.kilometers <= :kilometersMax');
            $parameters->add(new Parameter('kilometersMax', $kilometers[1]));
        }

        if($circulationYear)
        {
            $qb->andWhere('a.circulationYear >= :circulationYearMin');
            $parameters->add(new Parameter('circulationYearMin', $circulationYear[0]));
            $qb->andWhere('a.circulationYear <= :circulationYearMax');
            $parameters->add(new Parameter('circulationYearMax', $circulationYear[1]));
        }
        if($price)
        {
            $qb->andWhere('a.price >= :priceMin');
            $parameters->add(new Parameter('priceMin', $price[0]));
            $qb->andWhere('a.price <= :priceMax');
            $parameters->add(new Parameter('priceMax', $price[1]));
        }

             return $qb->setParameters($parameters)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
             ->getResult()
        ;

    }


}
