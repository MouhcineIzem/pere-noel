<?php

namespace App\Repository;

use App\Entity\Adresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adresse[]    findAll()
 * @method Adresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adresse::class);
    }

    // /**
    //  * @return Adresse[] Returns an array of Adresse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findUsersAddresses()
    {
        $query = $this->createQueryBuilder('a')
            ->innerJoin('a.users', 'users')

            ->getQuery()
        ;

        //dd($query->getSQL(), $query->getResult());
        return $query->getResult();
    }

    public function findUniqueAddresses()
    {
        $query = $this->createQueryBuilder('a')
            ->select('distinct a.ville')
            ->getQuery()
        ;

        return $query->getResult();
        //dd($query->getSQL(), $query->getResult());
    }

    public function findAddressByCity(string $city)
    {
        $query = $this->createQueryBuilder('a')
            ->innerJoin('a.users', 'users')
            ->where('a.ville = :city')
            ->setParameter('city', $city)
            ->getQuery()
        ;

        return $query->getResult();
    }

}
