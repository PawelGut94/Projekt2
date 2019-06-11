<?php

namespace App\Repository;

use App\Entity\OfferCarModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OfferCarModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferCarModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferCarModel[]    findAll()
 * @method OfferCarModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferCarModelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OfferCarModel::class);
    }

//    /**
//     * @return OfferCarModel[] Returns an array of OfferCarModel objects
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
    public function findOneBySomeField($value): ?OfferCarModel
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
