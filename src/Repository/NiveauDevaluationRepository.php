<?php

namespace App\Repository;

use App\Entity\NiveauDevaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiveauDevaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiveauDevaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiveauDevaluation[]    findAll()
 * @method NiveauDevaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauDevaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiveauDevaluation::class);
    }

    // /**
    //  * @return NiveauDevaluation[] Returns an array of NiveauDevaluation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NiveauDevaluation
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
