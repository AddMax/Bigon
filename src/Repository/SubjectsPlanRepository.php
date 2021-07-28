<?php

namespace App\Repository;

use App\Entity\SubjectsPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubjectsPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectsPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectsPlan[]    findAll()
 * @method SubjectsPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectsPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectsPlan::class);
    }

    // /**
    //  * @return SubjectsPlan[] Returns an array of SubjectsPlan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubjectsPlan
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
