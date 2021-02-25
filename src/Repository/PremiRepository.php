<?php

namespace App\Repository;

use App\Entity\Premi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Premi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Premi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Premi[]    findAll()
 * @method Premi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PremiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Premi::class);
    }

    /**
     * @return Premi[]
     */
    public function findAllGreaterThanPrice(int $price): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Premi p
            WHERE p.valor > :valor
            ORDER BY p.valor DESC'
        )->setParameter('valor', $price);

        // returns an array of Product objects
        return $query->getResult();
    }


    // /**
    //  * @return Premi[] Returns an array of Premi objects
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
    public function findOneBySomeField($value): ?Premi
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
