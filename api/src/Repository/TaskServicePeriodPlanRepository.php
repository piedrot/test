<?php

namespace App\Repository;

use App\Entity\TaskServicePeriodPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskServicePeriodPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskServicePeriodPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskServicePeriodPlan[]    findAll()
 * @method TaskServicePeriodPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskServicePeriodPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskServicePeriodPlan::class);
    }

    // /**
    //  * @return TaskServicePeriodPlan[] Returns an array of TaskServicePeriodPlan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskServicePeriodPlan
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
