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
class CarRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarMark::class);
    }
    public function findModel($model)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->andWhere('o.model LIKE :model')
            ->setParameter('model', '%'.$model.'%');
        $query=$qb->getQuery();

        return $query->getResult();

    }
    public function findCar($mark,$model)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->andWhere('o.mark = :mark')
            ->andWhere('o.model LIKE :model')
            ->setParameter('mark', $mark)
            ->setParameter('model', '%'.$model.'%');
        $query=$qb->getQuery();

        return $query->getResult();

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
