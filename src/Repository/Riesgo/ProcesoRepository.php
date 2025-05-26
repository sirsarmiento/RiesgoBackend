<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Proceso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Proceso|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proceso|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proceso[]    findAll()
 * @method Proceso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcesoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proceso::class);
    }

    // /**
    //  * @return Proceso[] Returns an array of Proceso objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Proceso
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
