<?php

namespace App\Repository;

use App\Entity\UsersAnd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UsersAnd|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersAnd|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersAnd[]    findAll()
 * @method UsersAnd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersAndRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersAnd::class);
    }

    // /**
    //  * @return UsersAnd[] Returns an array of UsersAnd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsersAnd
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
