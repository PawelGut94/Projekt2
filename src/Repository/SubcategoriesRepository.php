<?php

namespace App\Repository;

use App\Entity\Subcategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subcategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subcategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subcategories[]    findAll()
 * @method Subcategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcategoriesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subcategories::class);
    }

    public function findFirstSubcategory()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->andWhere('s.category < 5');
        $query=$qb->getQuery();
        return $query->getResult();

    }
    public function findSecondSubcategory()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->andWhere('s.category > 4');
        $qb->andWhere('s.category < 9');
        $query=$qb->getQuery();
        return $query->getResult();

    }
    public function findThirdSubcategory()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->andWhere('s.category > 8');
        $qb->andWhere('s.category < 13');
        $query=$qb->getQuery();
        return $query->getResult();

    }

//    /**
//     * @return Subcategories[] Returns an array of Subcategories objects
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
    public function findOneBySomeField($value): ?Subcategories
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
