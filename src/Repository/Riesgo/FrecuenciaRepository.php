<?php

namespace App\Repository;

use App\Entity\Frecuencia;
use App\Dto\FrecuenciaOutPutDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

Use App\Entity\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use	Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Empresa;
/**
 * @method Frecuencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Frecuencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Frecuencia[]    findAll()
 * @method Frecuencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FrecuenciaRepository extends ServiceEntityRepository
{
    private $security;
    public function __construct(ManagerRegistry $registry,Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Frecuencia::class);
    }

}