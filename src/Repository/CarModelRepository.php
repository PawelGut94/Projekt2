<?php

namespace App\Repository;

use App\Entity\CarModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CarModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarModel[]    findAll()
 * @method CarModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarModelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarModel::class);
    }
    public function findModel($model)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->andWhere('o.name LIKE :model')
            ->setParameter('model', $model.' '.'%');
        $query=$qb->getQuery();

        return $query->getResult();

    }
    public function findCar($model)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->andWhere('o.name LIKE :model')
            ->setParameter('model', $model.' '.'%');
        $query=$qb->getQuery();

        return $query->getResult();

    }
//    /**
//     * @return CarModel[] Returns an array of CarModel objects
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
    public function findOneBySomeField($value): ?CarModel
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
