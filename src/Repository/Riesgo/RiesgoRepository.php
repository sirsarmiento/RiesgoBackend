<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Riesgo;
use App\Entity\Riesgo\Proceso;
use App\Entity\Riesgo\Control;
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

    /**
     * Update Causa.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(Riesgo::class)->find($id);
        if (!$entity) {
            return new JsonResponse(['msg'=>'No existen Registros con el id: '.$id],404);  
        }
        $entity=$helper->setParametersToEntity($entity,$data);
        $currentUser =$entityManager->getRepository(User::class)->find($this->security->getUser()->getId());
        $entity->setUpdateBy($currentUser->getUserName());
        $entity->setUpdateAt(new \DateTime());

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

        $errors = $validator->validate($entity);
        if($errors->count() > 0){
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse($messages,500);
        }else{
            $entityManager->persist($entity);
            $entityManager->flush();
            return new JsonResponse(['msg'=>'Registro Actualizado: '.$entity->getId()],200);
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
                'impact'        => $riesgo->getImpact()  == null ? 0 : $riesgo->getImpact()->getId(),
                'impactName'        => $riesgo->getImpact()  == null ? 0 : $riesgo->getImpact()->getDescripcion(),
                'frequency'        => $riesgo->getFrequency() == null ? 0 : $riesgo->getFrequency()->getId(),
                'frequencyName'        => $riesgo->getFrequency() == null ? 0 : $riesgo->getFrequency()->getDescripcion(),
                'description' => $riesgo->getDescription(),
                'affect'      => $riesgo->getAffect(),
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
                'affect'      => $riesgo->getAffect(),
                'impact'      => $riesgo->getImpact()  == null ? 0 : $riesgo->getImpact()->getId(),
                'frequency'   => $riesgo->getFrequency() == null ? 0 : $riesgo->getFrequency()->getId(),
                'responsibles'=> $responsibles,
                'processes' => $processes,
                'causes' => $causes,
            ];
        }
        return $result;
    }

    /**
     * Para llenar lista donde se asocian riesgos. Por ejemplo en el módulo de procesos se asocian riesgos
     */
    public function getAllForAssociate(): array
    {
        $entityManager = $this->getEntityManager();
        $riesgos = $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($riesgos as $riesgo) {
            $result[] = [
                'id'          => $riesgo->getId(),
                'name'        => $riesgo->getName(),
                'impact'        => $riesgo->getImpact()  == null ? '' : $riesgo->getImpact()->getDescripcion(),
                'frequency'        => $riesgo->getFrequency() == null ? '' : $riesgo->getFrequency()->getDescripcion()
            ];
        }
        return $result;
    }

    /**
     * Delete user from riesgo.
     */
    public function removeUserFromRisk($riskId, $userId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $risk= $em->getRepository(Riesgo::class)->find($riskId);
        $user = $em->getRepository(User::class)->find($userId);

        // Validar existencia
        if (!$risk || !$user) {
            return [
                'success' => false,
                'message' => 'Riesgo o responsable no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el usuario esté vinculado al proceso
        if (!$risk->getUsers()->contains($user)) {
           return [
                'success' => false,
                'message' => 'El responsable no está asignado a este riesgo.',
                'code' => 404
            ];
        }

        // Remover la relación
        $risk->removeUser($user);
        $user->removeRiesgo($risk);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }

    /**
     * Delete process from riesgo.
     */
    public function removeProcessFromRisk($riskId, $processId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $risk= $em->getRepository(Riesgo::class)->find($riskId);
        $process = $em->getRepository(Proceso::class)->find($processId);

        // Validar existencia
        if (!$risk || !$process) {
            return [
                'success' => false,
                'message' => 'Riesgo o proceso no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el usuario esté vinculado al proceso
        if (!$risk->getProcesos()->contains($process)) {
            return [
                'success' => false,
                'message' => 'El proceso no está asignado a este riesgo.',
                'code' => 404
            ];
        }

        // Remover la relación
        $risk->removeProceso($process);
        $process->removeRiesgo($risk);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }

    /**
     * Delete control from riesgo.
     */
    public function removeControlFromRisk($riskId, $controlId): array
    {
        $em = $this->getEntityManager();
   
        // Buscar las entidades por su ID
        $risk= $em->getRepository(Riesgo::class)->find($riskId);
        $control = $em->getRepository(Control::class)->find($controlId);

        // Validar existencia
        if (!$risk || !$control) {
            return [
                'success' => false,
                'message' => 'Riesgo o control no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el usuario esté vinculado al proceso
        if (!$risk->getControls()->contains($control)) {
            return [
                'success' => false,
                'message' => 'El control no está asignado a este riesgo.',
                'code' => 404
            ];
        }

        // Remover la relación
        $risk->removeControl($control);
        $control->removeRiesgo($risk);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }
}

  