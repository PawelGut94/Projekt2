<?php

namespace App\Repository;

use App\Entity\MainPagePhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MainPagePhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainPagePhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainPagePhoto[]    findAll()
 * @method MainPagePhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainPagePhotoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MainPagePhoto::class);
    }

//    /**
//     * @return MainPagePhoto[] Returns an array of MainPagePhoto objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainPagePhoto
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
