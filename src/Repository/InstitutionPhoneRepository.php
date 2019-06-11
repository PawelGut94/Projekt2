<?php

namespace App\Repository;

use App\Entity\InstitutionPhone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InstitutionPhone|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionPhone|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionPhone[]    findAll()
 * @method InstitutionPhone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionPhoneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InstitutionPhone::class);
    }

//    /**
//     * @return InstitutionPhone[] Returns an array of InstitutionPhone objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InstitutionPhone
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
