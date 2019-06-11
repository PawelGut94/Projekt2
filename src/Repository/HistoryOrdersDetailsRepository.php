<?php

namespace App\Repository;

use App\Entity\HistoryOrdersDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HistoryOrdersDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryOrdersDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryOrdersDetails[]    findAll()
 * @method HistoryOrdersDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryOrdersDetailsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HistoryOrdersDetails::class);
    }

//    /**
//     * @return HistoryOrdersDetails[] Returns an array of HistoryOrdersDetails objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HistoryOrdersDetails
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
