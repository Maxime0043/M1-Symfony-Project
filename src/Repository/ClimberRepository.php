<?php

namespace App\Repository;

use App\Entity\Climber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Climber|null find($id, $lockMode = null, $lockVersion = null)
 * @method Climber|null findOneBy(array $criteria, array $orderBy = null)
 * @method Climber[]    findAll()
 * @method Climber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClimberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Climber::class);
    }

    // /**
    //  * @return Climber[] Returns an array of Climber objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Climber
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
