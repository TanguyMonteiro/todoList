<?php

namespace App\Repository;

use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Todo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todo[]    findAll()
 * @method Todo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todo::class);
    }

    // /**
    //  * @return Todo[] Returns an array of Todo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     *  @return Todo[] Returns an array of Todo objects
     */

    public function findByUserSortedByMostRecent($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :val')
            ->setParameter('val', $value)
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     *  @return Todo[] Returns an array of Todo objects
     */
    public function findByUserSortedByLessRecent($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :val')
            ->setParameter('val', $value)
            ->orderBy('t.createdAt', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     *  @return Todo[] Returns an array of Todo objects
     */
    public function findByUserSortedByMostUrgent($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :val')
            ->setParameter('val', $value)
            ->orderBy('t.dueDate', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     *  @return Todo[] Returns an array of Todo objects
     */
    public function findByUserSortedByLeastUrgent($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :val')
            ->setParameter('val', $value)
            ->orderBy('t.dueDate', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Todo
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
