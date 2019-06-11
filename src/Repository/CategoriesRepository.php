<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    public function findFirstCategory()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.id', 'c.name','c.position')
            ->andWhere('c.position < 5');
        $query=$qb->getQuery();

        return $query->getResult();

    }
    public function findSecondCategory()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.id', 'c.name','c.position')
            ->andWhere('c.position > 4')
            ->andWhere('c.position < 9');
        $query=$qb->getQuery();

        return $query->getResult();

    }
    public function findThirdCategory()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.id', 'c.name','c.position')
            ->andWhere('c.position > 8')
            ->andWhere('c.position < 13');
        $query=$qb->getQuery();
        return $query->getResult();

    }
    public function findFourthCategory()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.id', 'c.name','c.position')
            ->andWhere('c.position < 5')
            ->andWhere('c.position < 5');
        $query=$qb->getQuery();

        return $query->getResult();

    }
//    /**
//     * @return Categories[] Returns an array of Categories objects
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
    public function findOneBySomeField($value): ?Categories
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
