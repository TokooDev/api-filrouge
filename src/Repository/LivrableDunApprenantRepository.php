<?php

namespace App\Repository;

use App\Entity\LivrableDunApprenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivrableDunApprenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivrableDunApprenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivrableDunApprenant[]    findAll()
 * @method LivrableDunApprenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrableDunApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivrableDunApprenant::class);
    }

    // /**
    //  * @return LivrableDunApprenant[] Returns an array of LivrableDunApprenant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LivrableDunApprenant
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
