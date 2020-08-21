<?php

namespace App\Repository;

use App\Entity\LivrablePartielDunApprenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivrablePartielDunApprenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivrablePartielDunApprenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivrablePartielDunApprenant[]    findAll()
 * @method LivrablePartielDunApprenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrablePartielDunApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivrablePartielDunApprenant::class);
    }

    // /**
    //  * @return LivrablePartielDunApprenant[] Returns an array of LivrablePartielDunApprenant objects
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
    public function findOneBySomeField($value): ?LivrablePartielDunApprenant
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
