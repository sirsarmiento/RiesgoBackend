<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Plan;
use App\Entity\Riesgo\Riesgo;
use App\Entity\Riesgo\Proceso;
use App\Entity\Riesgo\Control;
use App\Entity\Riesgo\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;

/**
 * @method Plan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plan[]    findAll()
 * @method Plan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Plan::class);
    }

    /**
     * Create Plan.
     */
    public function post($data,$validator,$helper): JsonResponse  {
       
        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new Plan(),$data);

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

            // Itera sobre los eventos y asocia cada uno con la entidad Plan
            foreach ($data["events"] as $key => $value) {
                $event = $entityManager->getRepository(\App\Entity\Riesgo\Evento::class)->find($value['id']);
                if ($event) {
                    $entity->addEvento($event);
                }
            }

            // Itera sobre los procesos y asocia cada uno con la entidad Plan
            foreach ($data["processes"] as $key => $value) {
                $process = $entityManager->getRepository(\App\Entity\Riesgo\Proceso::class)->find($value['id']);
                if ($process) {
                    $entity->addProceso($process);
                }
            }

            // Itera sobre los controles y asocia cada uno con la entidad Plan
            foreach ($data["controls"] as $key => $value) {
                $control = $entityManager->getRepository(\App\Entity\Riesgo\Control::class)->find($value['id']);
                if ($control) {
                    $entity->addControl($control);
                }
            }

            // Itera sobre los riesgos y asocia cada uno con la entidad Plan
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
     * Update Plan.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(Plan::class)->find($id);
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

        // Itera sobre los eventos cada uno con la entidad Plan
        foreach ($data["events"] as $key => $value) {
            $event = $entityManager->getRepository(\App\Entity\Riesgo\Evento::class)->find($value['id']);
            if ($event) {
                $entity->addEvento($event);
            }
        }

        // Itera sobre los procesos y asocia cada uno con la entidad Plan
        foreach ($data["processes"] as $key => $value) {
            $process = $entityManager->getRepository(\App\Entity\Riesgo\Proceso::class)->find($value['id']);
            if ($process) {
                $entity->addProceso($process);
            }
        }

        // Itera sobre los controles y asocia cada uno con la entidad Plan
        foreach ($data["controls"] as $key => $value) {
            $control = $entityManager->getRepository(\App\Entity\Riesgo\Control::class)->find($value['id']);
            if ($control) {
                $entity->addControl($control);
            }
        }

        // Itera sobre los riesgos y asocia cada uno con la entidad Plan
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
        $plans = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->addOrderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($plans as $plan) {
            $responsibles = [];
            $processes = [];
            $events = [];
            $controls = [];
            $risks = [];
            foreach ($plan->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($plan->getEventos() as $event) {
                $events[] = [
                    'id'          => $event->getId(),
                    'name'        => $event->getName()
                ];
            }
            foreach ($plan->getProcesos() as $process) {
                $processes[] = [
                    'id'          => $process->getId(),
                    'name'        => $process->getName(),
                    'type'        => $process->getType(),
                ];
            }
            foreach ($plan->getControls() as $control) {
                $controls[] = [
                    'id'          => $control->getId(),
                    'name'        => $control->getName(),
                    'type'     => $control->getQualify(),
                    'executionType' => $control->getExecutionType(),
                ];
            }
            foreach ($plan->getRiesgos() as $risk) {
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
                'id'          => $plan->getId(),
                'name'        => $plan->getName(),
                'description' => $plan->getDescription(),
                'startDate' => $plan->getStartDate()->format('Y-m-d'),
                'endDate' => $plan->getEndDate()->format('Y-m-d'),
                'responsibles' => $responsibles,
                'processes' => $processes,
                'events' => $events,
                'controls' => $controls,
                'risks' => $risks,
            ];
        }
        return $result;
    }

    public function getById($id): array
    {
        $entityManager = $this->getEntityManager();
        $plans = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        $result = [];
                foreach ($plans as $plan) {
            $responsibles = [];
            $processes = [];
            $events = [];
            $controls = [];
            $risks = [];
            foreach ($plan->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($plan->getEventos() as $event) {
                $events[] = [
                    'id'          => $event->getId(),
                    'name'        => $event->getName()
                ];
            }
            foreach ($plan->getProcesos() as $process) {
                $processes[] = [
                    'id'          => $process->getId(),
                    'name'        => $process->getName(),
                    'type'        => $process->getType(),
                ];
            }
            foreach ($plan->getControls() as $control) {
                $controls[] = [
                    'id'          => $control->getId(),
                    'name'        => $control->getName(),
                    'type'     => $control->getQualify(),
                    'executionType' => $control->getExecutionType(),
                ];
            }
            foreach ($plan->getRiesgos() as $risk) {
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
                'id'          => $plan->getId(),
                'name'        => $plan->getName(),
                'description' => $plan->getDescription(),
                'startDate' => $plan->getStartDate()->format('Y-m-d'),
                'endDate' => $plan->getEndDate()->format('Y-m-d'),
                'responsibles' => $responsibles,
                'processes' => $processes,
                'events' => $events,
                'controls' => $controls,
                'risks' => $risks,
            ];
        }
        return $result;
    }

    /**
     * Delete user from Plan.
     */
    public function removeUserFromPlan($pland, $userId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $plan = $em->getRepository(Plan::class)->find($pland);
        $user = $em->getRepository(User::class)->find($userId);

        // Validar existencia
        if (!$plan || !$user) {
            return [
                'success' => false,
                'message' => 'Plan o responsable no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el usuario esté vinculado al proceso
        if (!$risk->getUsers()->contains($user)) {
           return [
                'success' => false,
                'message' => 'El responsable no está asignado a este plan.',
                'code' => 404
            ];
        }

        // Remover la relación
        $risk->removeUser($user);
        $user->removePlan($risk);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }

    /**
     * Delete process from plan.
     */
    public function removeProcessFromPlan($pland, $processId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $plan = $em->getRepository(Plan::class)->find($pland);
        $process = $em->getRepository(Proceso::class)->find($processId);

        // Validar existencia
        if (!$plan || !$process) {
            return [
                'success' => false,
                'message' => 'Plan o proceso no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el proceso esté vinculado al proceso
        if (!$plan->getProcesos()->contains($process)) {
            return [
                'success' => false,
                'message' => 'El proceso no está asignado a este plan.',
                'code' => 404
            ];
        }

        // Remover la relación
        $plan->removeProceso($process);
        $process->removePlan($plan);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }

    /**
     * Delete control from plan.
     */
    public function removeControlFromPlan($pland, $controlId): array
    {
        $em = $this->getEntityManager();
       // Buscar las entidades por su ID
       $plan = $em->getRepository(Plan::class)->find($pland);
       $control = $em->getRepository(Control::class)->find($controlId);

       // Validar existencia
       if (!$plan || !$control) {
           return [
                'success' => false,
                'message' => 'Plan o control no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el control esté vinculado al proceso
        if (!$plan->getControls()->contains($control)) {
            return [
                'success' => false,
                'message' => 'El control no está asignado a este plan.',
                'code' => 404
            ];
        }

        // Remover la relación
        $plan->removeControl($control);
        $control->removePlan($plan);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }

    /**
     * Delete Risk from plan.
     */
    public function removeRiskFromPlan($pland, $riskId): array
    {
        $em = $this->getEntityManager();
       // Buscar las entidades por su ID
       $plan = $em->getRepository(Plan::class)->find($pland);
       $risk = $em->getRepository(Riesgo::class)->find($riskId);

       // Validar existencia
       if (!$plan || !$risk) {
           return [
                'success' => false,
                'message' => 'Plan o control no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el riesgo esté vinculado al proceso
        if (!$plan->getRiesgos()->contains($risk)) {
            return [
                'success' => false,
                'message' => 'El riesgo no está asignado a este plan.',
                'code' => 404
            ];
        }

        // Remover la relación
        $plan->removeRiesgo($risk);
        $risk->removePlan($plan);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }

    /**
     * Delete Event from plan.
     */
    public function removeEventFromPlan($pland, $eventId): array
    {
       $em = $this->getEntityManager();
       // Buscar las entidades por su ID
       $plan = $em->getRepository(Plan::class)->find($pland);
       $event = $em->getRepository(Evento::class)->find($eventId);

       // Validar existencia
       if (!$plan || !$event) {
           return [
                'success' => false,
                'message' => 'Plan o control no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el cause esté vinculado al proceso
        if (!$plan->getEventos()->contains($event)) {
            return [
                'success' => false,
                'message' => 'El evento no está asignado a este plan.',
                'code' => 404
            ];
        }

        // Remover la relación
        $plan->removeEvento($event);
        $event->removePlan($plan);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }
}
