<?php

namespace App\Repository;

use App\Entity\OfferCarMark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OfferCarMark|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferCarMark|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferCarMark[]    findAll()
 * @method OfferCarMark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferCarMarkRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OfferCarMark::class);
    }

//    /**
//     * @return OfferCarMark[] Returns an array of OfferCarMark objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OfferCarMark
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
