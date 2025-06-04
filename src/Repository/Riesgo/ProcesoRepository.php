<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Proceso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;
/**
 * @method Proceso|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proceso|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proceso[]    findAll()
 * @method Proceso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcesoRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Proceso::class);
    }

    /**
     * Create proceso.
     */
    public function post($data,$validator,$helper): JsonResponse  {

        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new Proceso(),$data);

        $errors = $validator->validate($entity);
        if($errors->count() > 0){
            $errorsString = (string) $errors;
            return new JsonResponse(['msg'=>$errorsString],500);
        }else{
            $currentUser =$entityManager->getRepository(User::class)->find($this->security->getUser()->getId());
            $entity->setCreateBy($currentUser->getUserName());
       
            $empresa= $entityManager->getRepository(Empresa::class)->find($this->security->getUser()->getIdempresa());
            
            if($empresa)
                $entity->setEmpresa($empresa);  
            
            foreach ($data["responsibles"] as $key => $value) {
                $user = $entityManager->getRepository(\App\Entity\User::class)->find($value['id']);
                if ($user) {
                    $entity->addUser($user);
                }
            }

            foreach ($data["risks"] as $key => $value) {
                $risk = $entityManager->getRepository(\App\Entity\Riesgo\Riesgo::class)->find($value['id']);
                if ($risk) {
                    $entity->addRiesgo($risk);
                }
            }

            $entityManager->persist($entity);
            $entityManager->flush();

            return new JsonResponse(['msg'=>'Registro Creado','id'=>$entity->getId()],200);
        }    
    }

    public function getAll(): array
    {
        $entityManager = $this->getEntityManager();
        $procesos = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->leftJoin('p.riesgos', 'r')
            ->addSelect('u', 'r')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($procesos as $proceso) {
            $responsibles = [];
            $risks = [];
            foreach ($proceso->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($proceso->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'description' => $risk->getDescription(),
                ];
            }
            $result[] = [
                'id'          => $proceso->getId(),
                'code'          => $proceso->getCode(),
                'name'        => $proceso->getName(),
                'category'   => $proceso->getCategory(),
                'type'   => $proceso->getType(),
                'process'   => $proceso->getProcess(),
                'unit'   => $proceso->getUnit(),
                'descripcion' => $proceso->getDescription(),
                'responsibles' => $responsibles,
                'risks' => $risks,
            ];
        }
        return $result;
    }

    public function getById($id): array
    {
        $entityManager = $this->getEntityManager();
        $procesos = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($procesos as $proceso) {
            $responsibles = [];
            $risks = [];
            foreach ($proceso->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($proceso->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'description' => $risk->getDescription(),
                ];
            }
            $result[] = [
                'id'          => $proceso->getId(),
                'code'          => $proceso->getCode(),
                'name'        => $proceso->getName(),
                'category'   => $proceso->getCategory(),
                'type'   => $proceso->getType(),
                'process'   => $proceso->getProcess(),
                'unit'   => $proceso->getUnit(),
                'descripcion' => $proceso->getDescription(),
                'responsibles' => $responsibles,
                'risks' => $risks,
            ];
        }
        return $result;
    }
}
