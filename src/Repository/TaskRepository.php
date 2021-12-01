<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * return Task[]
     */
    public function findDataByID($value): array{
        // $entityManager = $this->getEntityManager();

        // $query = $entityManager->createQuery(
        //     'SELECT * FROM App\Entity\Task t WHERE t.user = :value ORDER BY t.id ASC'
        // )->setParameter('value',$value);

        // return $query->getResult();

        $qb = $this->createQueryBuilder('t')
            ->where('t.user = :value')
            ->setParameter('value', $value)
            ->orderBy('t.id', 'ASC');

        $query = $qb->getQuery();
         return $query->execute();
    }

    /**
     * return Task[]
     */
    public function findDataByInnerJoiningTables($value): array{              
        

        $qb = $this->createQueryBuilder('t');
        $qb->select('t')
            ->innerJoin('App\Entity\User', 'u', Join::WITH, 'u=t.user')
            ->where('t.user = :value')
            ->setParameter('value', $value)
            ->orderBy('t.id', 'ASC');      
        

        $query = $qb->getQuery();
        return $query->execute();       
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
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

    /*
    public function findOneBySomeField($value): ?Task
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
