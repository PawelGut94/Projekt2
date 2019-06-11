<?php

namespace App\Repository;

use App\Entity\SearchOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SearchOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchOffer[]    findAll()
 * @method SearchOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchOfferRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SearchOffer::class);
    }

//    /**
//     * @return SearchOffer[] Returns an array of SearchOffer objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SearchOffer
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
