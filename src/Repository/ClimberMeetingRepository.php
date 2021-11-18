<?php

namespace App\Repository;

use App\Entity\ClimberMeeting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClimberMeeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClimberMeeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClimberMeeting[]    findAll()
 * @method ClimberMeeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClimberMeetingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClimberMeeting::class);
    }

    // /**
    //  * @return ClimberMeeting[] Returns an array of ClimberMeeting objects
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
    public function findOneBySomeField($value): ?ClimberMeeting
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
