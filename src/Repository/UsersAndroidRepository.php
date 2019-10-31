<?php

namespace App\Repository;

use App\Entity\UsersAndroid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UsersAndroid|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersAndroid|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersAndroid[]    findAll()
 * @method UsersAndroid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersAndroidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersAndroid::class);
    }

    // /**
    //  * @return UsersAndroid[] Returns an array of UsersAndroid objects
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
    public function findOneBySomeField($value): ?UsersAndroid
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
