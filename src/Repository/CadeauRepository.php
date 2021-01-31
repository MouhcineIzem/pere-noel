<?php

namespace App\Repository;

use App\Model\Search;
use App\Entity\Cadeau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cadeau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cadeau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cadeau[]    findAll()
 * @method Cadeau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cadeau::class);
    }

    /**
     * @param Search $search
     */
    public function findWithSearch(Search $search)
    {
        $query = $this
                    ->createQueryBuilder('c')
                    ->select('ca', 'c')
                    ->join('c.categorie', 'ca');

        if (!empty($search->categories)) {
            $query = $query
                        ->andWhere('ca.id IN (:categories)')
                        ->setParameter('categories', $search->categories);
        }

        if (!empty($search->string)) {
            $query = $query
                ->andWhere('c.designation LIKE :string')
                ->setParameter('string', "%{$search->string}%");
        }

        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Cadeau[] Returns an array of Cadeau objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findCadeauxCommandes()
    {
        return $this->createQueryBuilder('c')
           ->innerJoin('c.paniers', 'p')
           ->addSelect('p')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCadeauxByAge($age)
    {
        return $this->createQueryBuilder('c')
            ->where('c.age <= :age')
            ->setParameter('age', $age)
            ->getQuery()
            ->getResult()
            ;
    }
}
