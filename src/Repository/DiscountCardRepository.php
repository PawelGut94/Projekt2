<?php

namespace App\Repository;

use App\Entity\DiscountCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DiscountCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscountCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscountCard[]    findAll()
 * @method DiscountCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountCardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DiscountCard::class);
    }

//    /**
//     * @return DiscountCard[] Returns an array of DiscountCard objects
//     */
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
    public function findOneBySomeField($value): ?DiscountCard
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
