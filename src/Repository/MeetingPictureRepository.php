<?php

namespace App\Repository;

use App\Entity\MeetingPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MeetingPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetingPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetingPicture[]    findAll()
 * @method MeetingPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetingPicture::class);
    }

    // /**
    //  * @return MeetingPicture[] Returns an array of MeetingPicture objects
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
    public function findOneBySomeField($value): ?MeetingPicture
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
