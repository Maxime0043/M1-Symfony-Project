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

    public function isClimberAlreadyRegister(int $climber, int $meeting)
    {
        return $this->createQueryBuilder('cm')
            ->where('cm.climber = :climber')
            ->andWhere('cm.meeting = :meeting')
            ->setParameters([
                'climber'   => $climber,
                'meeting'   => $meeting
            ])
            ->getQuery()
            ->getResult();
    }

    public function getNonParticipatedMeetings(int $climber)
    {
        return $this->createQueryBuilder('cm')
            ->where('cm.climber = :climber')
            ->andWhere('cm.has_participated = :participated')
            ->setParameters([
                'climber'       => $climber,
                'participated'  => false
            ])
            ->join('cm.meeting', 'm')
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getParticipatedMeetings(int $climber)
    {
        return $this->createQueryBuilder('cm')
            ->where('cm.climber = :climber')
            ->andWhere('cm.has_participated = :participated')
            ->setParameters([
                'climber'       => $climber,
                'participated'  => true
            ])
            ->join('cm.meeting', 'm')
            ->orderBy('m.date', 'DESC')
            ->getQuery()
            ->getResult();
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
