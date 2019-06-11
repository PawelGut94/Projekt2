<?php

namespace App\Repository;

use App\Entity\OfferPhotos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OfferPhotos|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferPhotos|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferPhotos[]    findAll()
 * @method OfferPhotos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferPhotosRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OfferPhotos::class);
    }

//    /**
//     * @return OfferPhotos[] Returns an array of OfferPhotos objects
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
    public function findOneBySomeField($value): ?OfferPhotos
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
