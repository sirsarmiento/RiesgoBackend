<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Evento;
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
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Evento::class);
    }

    /**
     * Create Evento.
     */
    public function post($data,$validator,$helper): JsonResponse  {
       
        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new Evento(),$data);

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

            // Itera sobre las Causas y asocia cada uno con la entidad Evento
            foreach ($data["causes"] as $key => $value) {
                $cause = $entityManager->getRepository(\App\Entity\Riesgo\CausaConsecuencia::class)->find($value['id']);
                if ($cause) {
                    $entity->addCausaConsecuencia($cause);
                }
            }

            // Itera sobre los procesos y asocia cada uno con la entidad Evento
            foreach ($data["processes"] as $key => $value) {
                $process = $entityManager->getRepository(\App\Entity\Riesgo\Proceso::class)->find($value['id']);
                if ($process) {
                    $entity->addProceso($process);
                }
            }

            // Itera sobre los controles y asocia cada uno con la entidad Evento
            foreach ($data["controls"] as $key => $value) {
                $control = $entityManager->getRepository(\App\Entity\Riesgo\Control::class)->find($value['id']);
                if ($control) {
                    $entity->addControl($control);
                }
            }

            // Itera sobre los eventos y asocia cada uno con la entidad Evento
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

    /**
     * Update Evento.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(Evento::class)->find($id);
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

        // Itera sobre las Causas y asocia cada uno con la entidad Evento
        foreach ($data["causes"] as $key => $value) {
            $cause = $entityManager->getRepository(\App\Entity\Riesgo\CausaConsecuencia::class)->find($value['id']);
            if ($cause) {
                $entity->addCausaConsecuencia($cause);
            }
        }

        // Itera sobre los procesos y asocia cada uno con la entidad Evento
        foreach ($data["processes"] as $key => $value) {
            $process = $entityManager->getRepository(\App\Entity\Riesgo\Proceso::class)->find($value['id']);
            if ($process) {
                $entity->addProceso($process);
            }
        }

        // Itera sobre los controles y asocia cada uno con la entidad Evento
        foreach ($data["controls"] as $key => $value) {
            $control = $entityManager->getRepository(\App\Entity\Riesgo\Control::class)->find($value['id']);
            if ($control) {
                $entity->addControl($control);
            }
        }

        // Itera sobre los eventos y asocia cada uno con la entidad Evento
        foreach ($data["risks"] as $key => $value) {
            $risk = $entityManager->getRepository(\App\Entity\Riesgo\Riesgo::class)->find($value['id']);
            if ($risk) {
                $entity->addRiesgo($risk);
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
        $eventos = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->addOrderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($eventos as $evento) {
            $responsibles = [];
            $processes = [];
            $causes = [];
            $controls = [];
            $risks = [];
            foreach ($evento->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($evento->getCausaConsecuencias() as $cause) {
                $causes[] = [
                    'id'          => $cause->getId(),
                    'name'        => $cause->getName(),
                    'type'       => $cause->getType(),
                ];
            }
            foreach ($evento->getProcesos() as $process) {
                $processes[] = [
                    'id'          => $process->getId(),
                    'name'        => $process->getName(),
                    'type'        => $process->getType(),
                ];
            }
            foreach ($evento->getControls() as $control) {
                $controls[] = [
                    'id'          => $control->getId(),
                    'name'        => $control->getName(),
                    'type'     => $control->getQualify(),
                    'executionType' => $control->getExecutionType(),
                ];
            }
            foreach ($evento->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'impact'      => $risk->getImpact()  == null ? 0 : $risk->getImpact()->getId(),
                    'impactName'  => $risk->getImpact()  == null ? '' : $risk->getImpact()->getDescripcion(),
                    'frecuency'   => $risk->getFrequency() == null ? 0 : $risk->getFrequency()->getId(),
                    'frequencyName'  => $risk->getFrequency() == null ? '' : $risk->getFrequency()->getDescripcion(),
                ];
            }
            $result[] = [
                'id'          => $evento->getId(),
                'name'        => $evento->getName(),
                'description' => $evento->getDescription(),
                'whereOcurred' => $evento->getWhereOcurred(),
                'startDate' => $evento->getStartDate()->format('Y-m-d'),
                'startTime' => $evento->getStartTime(),
                'discoveryDate' => $evento->getDiscoveryDate()->format('Y-m-d'),
                'discoveryTime' => $evento->getDiscoveryTime(),
                'state' => $evento->getState(),
                'criticality' => $evento->getCriticality(),
                'generateLoss' => $evento->getGenerateLoss(),
                'responsibles' => $responsibles,
                'processes' => $processes,
                'causes' => $causes,
                'controls' => $controls,
                'risks' => $risks,
            ];
        }
        return $result;
    }

    public function getById($id): array
    {
        $entityManager = $this->getEntityManager();
        $eventos = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($eventos as $evento) {
            $responsibles = [];
            $processes = [];
            $causes = [];
            $risks = [];
            $controls = [];
            foreach ($evento->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($evento->getCausaConsecuencias() as $cause) {
                $causes[] = [
                    'id'          => $cause->getId(),
                    'name'        => $cause->getName(),
                    'type' => $cause->getType(),
                ];
            }
            foreach ($evento->getProcesos() as $process) {
                $processes[] = [
                    'id'          => $process->getId(),
                    'name'        => $process->getName(),
                    'type'        => $process->getType(),
                ];
            }
            foreach ($evento->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'impact'      => $risk->getImpact()  == null ? 0 : $risk->getImpact()->getId(),
                    'impactName'  => $risk->getImpact()  == null ? '' : $risk->getImpact()->getDescripcion(),
                    'frecuency'   => $risk->getFrequency() == null ? 0 : $risk->getFrequency()->getId(),
                    'frequencyName'  => $risk->getFrequency() == null ? '' : $risk->getFrequency()->getDescripcion(),
                ];
            }
            foreach ($evento->getControles() as $control) {
                $controls[] = [
                    'id'          => $control->getId(),
                    'name'        => $control->getName(),
                    'type'        => $control->getType(),
                ];
            }
           $result[] = [
                'id'          => $evento->getId(),
                'name'        => $evento->getName(),
                'description' => $evento->getDescription(),
                'responsibles' => $responsibles,
                'processes' => $processes,
                'causes' => $causes,
                'controls' => $controls,
                'risks' => $risks,
            ];
        }
        return $result;
    }

    /**
     * Delete user from evento.
     */
    public function removeUserFromEvent($eventId, $userId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $event = $em->getRepository(Evento::class)->find($eventId);
        $user = $em->getRepository(User::class)->find($userId);

        // Validar existencia
        if (!$event || !$user) {
            return [
                'success' => false,
                'message' => 'Evento o responsable no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el usuario esté vinculado al proceso
        if (!$risk->getUsers()->contains($user)) {
           return [
                'success' => false,
                'message' => 'El responsable no está asignado a este evento.',
                'code' => 404
            ];
        }

        // Remover la relación
        $risk->removeUser($user);
        $user->removeEvento($risk);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }

    /**
     * Delete process from evento.
     */
    public function removeProcessFromEvent($eventId, $processId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $event = $em->getRepository(Evento::class)->find($eventId);
        $process = $em->getRepository(Proceso::class)->find($processId);

        // Validar existencia
        if (!$event || !$process) {
            return [
                'success' => false,
                'message' => 'Evento o proceso no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el usuario esté vinculado al proceso
        if (!$event->getProcesos()->contains($process)) {
            return [
                'success' => false,
                'message' => 'El proceso no está asignado a este evento.',
                'code' => 404
            ];
        }

        // Remover la relación
        $event->removeProceso($process);
        $process->removeEvento($event);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }

    /**
     * Delete control from evento.
     */
    public function removeControlFromEvent($eventId, $controlId): array
    {
        $em = $this->getEntityManager();
       // Buscar las entidades por su ID
       $event = $em->getRepository(Evento::class)->find($eventId);
       $control = $em->getRepository(Control::class)->find($controlId);

       // Validar existencia
       if (!$event || !$control) {
           return [
                'success' => false,
                'message' => 'Evento o control no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el usuario esté vinculado al proceso
        if (!$event->getControls()->contains($control)) {
            return [
                'success' => false,
                'message' => 'El control no está asignado a este evento.',
                'code' => 404
            ];
        }

        // Remover la relación
        $event->removeControl($control);
        $control->removeEvento($event);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }
}
