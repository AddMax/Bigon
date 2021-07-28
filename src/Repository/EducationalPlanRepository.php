<?php

namespace App\Repository;

use App\Entity\EducationalPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EducationalPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method EducationalPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method EducationalPlan[]    findAll()
 * @method EducationalPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EducationalPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EducationalPlan::class);
    }

    // /**
    //  * @return EducationalPlan[] Returns an array of EducationalPlan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EducationalPlan
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
