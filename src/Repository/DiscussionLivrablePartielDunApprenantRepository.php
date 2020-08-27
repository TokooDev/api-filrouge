<?php

namespace App\Repository;

use App\Entity\DiscussionLivrablePartielDunApprenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DiscussionLivrablePartielDunApprenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscussionLivrablePartielDunApprenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscussionLivrablePartielDunApprenant[]    findAll()
 * @method DiscussionLivrablePartielDunApprenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscussionLivrablePartielDunApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscussionLivrablePartielDunApprenant::class);
    }

    // /**
    //  * @return DiscussionLivrablePartielDunApprenant[] Returns an array of DiscussionLivrablePartielDunApprenant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DiscussionLivrablePartielDunApprenant
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
