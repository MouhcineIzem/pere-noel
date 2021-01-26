<?php

namespace App\Repository;

use App\Entity\Cadeau;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }


    public function updatePriceWithPercent(Categorie $categorie, float $pourcentage)
    {
        $qb = $this->createQueryBuilder('c');
            $qb->join('c.cadeaus', 'ca')
            ->update(Cadeau::class, 'ca')
            ->set('ca.prix', sprintf('ca.prix + ca.prix*%f', $pourcentage))
            ->where('ca.categorie = :categorie')
            ->setParameter('categorie', $categorie)
            ->getQuery()
            ->execute();
        ;
//        $query = $this
//            ->createQueryBuilder('c')
//            ->update('ca', 'c')
//            ->join('c.categorie', 'ca');
//
//        if (!empty($pourcentage->pourcentage)) {
//            $query = $query
//                ->andWhere('ca.prix =  ca.prix (:pourcentage)')
//                ->setParameter('pourcentage', $pourcentage->pourcentage);
//        }
//
//        return $query->getQuery()->getResult();

    }


    /*
    public function findOneBySomeField($value): ?Categorie
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
