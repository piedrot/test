<?php

namespace App\Repository;

use App\Entity\TaskService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskService|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskService|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskService[]    findAll()
 * @method TaskService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskService::class);
    }

    // /**
    //  * @return TaskService[] Returns an array of TaskService objects
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
    public function findOneBySomeField($value): ?TaskService
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
