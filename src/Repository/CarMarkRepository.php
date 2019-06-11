<?php

namespace App\Repository;

use App\Entity\CarMark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CarMark|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarMark|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarMark[]    findAll()
 * @method CarMark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarMarkRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarMark::class);
    }

//    /**
//     * @return CarMark[] Returns an array of CarMark objects
//     */
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

    /*
    public function findOneBySomeField($value): ?CarMark
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
