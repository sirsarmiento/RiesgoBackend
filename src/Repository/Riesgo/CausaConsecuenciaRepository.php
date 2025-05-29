<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\CausaConsecuencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;

/**
 * @method CausaConsecuencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method CausaConsecuencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method CausaConsecuencia[]    findAll()
 * @method CausaConsecuencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CausaConsecuenciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CausaConsecuencia::class);
    }

    // /**
    //  * @return CausaConsecuencia[] Returns an array of CausaConsecuencia objects
    //  */
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
    public function findOneBySomeField($value): ?CausaConsecuencia
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
