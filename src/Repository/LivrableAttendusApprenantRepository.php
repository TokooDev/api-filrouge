<?php

namespace App\Repository;

use App\Entity\LivrableAttendusApprenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivrableAttendusApprenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivrableAttendusApprenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivrableAttendusApprenant[]    findAll()
 * @method LivrableAttendusApprenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrableAttendusApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivrableAttendusApprenant::class);
    }

    // /**
    //  * @return LivrableAttendusApprenant[] Returns an array of LivrableAttendusApprenant objects
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
    public function findOneBySomeField($value): ?LivrableAttendusApprenant
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
