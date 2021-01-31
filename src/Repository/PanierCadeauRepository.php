<?php

namespace App\Repository;

use App\Entity\PanierCadeau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PanierCadeau|null find($id, $lockMode = null, $lockVersion = null)
 * @method PanierCadeau|null findOneBy(array $criteria, array $orderBy = null)
 * @method PanierCadeau[]    findAll()
 * @method PanierCadeau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierCadeauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PanierCadeau::class);
    }

    // /**
    //  * @return PanierCadeau[] Returns an array of PanierCadeau objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PanierCadeau
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
