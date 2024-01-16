<?php

namespace App\Repository;

use App\Entity\Arrivee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Arrivee>
 *
 * @method Arrivee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arrivee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arrivee[]    findAll()
 * @method Arrivee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArriveeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arrivee::class);
    }

//    /**
//     * @return Arrivee[] Returns an array of Arrivee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Arrivee
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
