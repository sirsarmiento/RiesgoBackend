<?php

namespace App\Repository;

use App\Entity\Impacto;
use App\Dto\ImpactoOutPutDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

Use App\Entity\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use	Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Empresa;
/**
 * @method Impacto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Impacto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Impacto[]    findAll()
 * @method Impacto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImpactoRepository extends ServiceEntityRepository
{
    private $security;
    public function __construct(ManagerRegistry $registry,Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Impacto::class);
    }

}