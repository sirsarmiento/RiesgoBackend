<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Riesgo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;

/**
 * @method Riesgo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Riesgo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Riesgo[]    findAll()
 * @method Riesgo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RiesgoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Riesgo::class);
    }

    /**
     * Create Riesgo.
     */
    public function post($data,$validator,$helper): JsonResponse  {
       
        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new Riesgo(),$data);

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

            // Itera sobre las Causas y asocia cada uno con la entidad Riesgo
            foreach ($data["causes"] as $key => $value) {
                $cause = $entityManager->getRepository(\App\Entity\Riesgo\CausaConsecuencia::class)->find($value['id']);
                if ($cause) {
                    $entity->addCausaConsecuencia($cause);
                }
            }

            // Itera sobre los procesos y asocia cada uno con la entidad Riesgo
            foreach ($data["processes"] as $key => $value) {
                $process = $entityManager->getRepository(\App\Entity\Riesgo\Proceso::class)->find($value['id']);
                if ($process) {
                    $entity->addProceso($process);
                }
            }

            foreach ($data["controls"] as $key => $value) {
                $control = $entityManager->getRepository(\App\Entity\Riesgo\Control::class)->find($value['id']);
                if ($control) {
                    $entity->addControl($control);
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
        $riesgos = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($riesgos as $riesgo) {
            $responsibles = [];
            $processes = [];
            $causes = [];
            $controls = [];
            foreach ($riesgo->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($riesgo->getCausaConsecuencias() as $cause) {
                $causes[] = [
                    'id'          => $cause->getId(),
                    'name'        => $cause->getName(),
                    'type'       => $cause->getType(),
                ];
            }
            foreach ($riesgo->getProcesos() as $process) {
                $processes[] = [
                    'id'          => $process->getId(),
                    'name'        => $process->getName(),
                    'type'        => $process->getType(),
                ];
            }
            foreach ($riesgo->getControls() as $control) {
                $controls[] = [
                    'id'          => $control->getId(),
                    'name'        => $control->getName(),
                    'type'     => $control->getQualify(),
                    'executionType' => $control->getExecutionType(),
                ];
            }
            $result[] = [
                'id'          => $riesgo->getId(),
                'name'        => $riesgo->getName(),
                'description' => $riesgo->getDescription(),
                'responsibles' => $responsibles,
                'processes' => $processes,
                'causes' => $causes,
                'controls' => $controls,
            ];
        }
        return $result;
    }

    public function getById($id): array
    {
        $entityManager = $this->getEntityManager();
        $riesgos = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($riesgos as $riesgo) {
            $responsibles = [];
            $processes = [];
            $causes = [];
            foreach ($riesgo->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($riesgo->getCausaConsecuencias() as $cause) {
                $causes[] = [
                    'id'          => $cause->getId(),
                    'name'        => $cause->getName(),
                    'type' => $cause->getType(),
                ];
            }
            foreach ($riesgo->getProcesos() as $process) {
                $processes[] = [
                    'id'          => $process->getId(),
                    'name'        => $process->getName(),
                    'type'        => $process->getType(),
                ];
            }
            $result[] = [
                'id'          => $riesgo->getId(),
                'name'        => $riesgo->getName(),
                'description' => $riesgo->getDescription(),
                'responsibles' => $responsibles,
                'processes' => $processes,
                'causes' => $causes,
            ];
        }
        return $result;
    }
}

  