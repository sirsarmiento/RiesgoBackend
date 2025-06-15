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

    /**
     * Update Proceso.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(Proceso::class)->find($id);
        if (!$entity) {
            return new JsonResponse(['msg'=>'No existen Registros con el id: '.$id],404);  
        }
        $entity=$helper->setParametersToEntity($entity,$data);
        $currentUser =$entityManager->getRepository(User::class)->find($this->security->getUser()->getId());
        $entity->setUpdateBy($currentUser->getUserName());
        $entity->setUpdateAt(new \DateTime());

        foreach ($data["responsibles"] as $key => $value) {
            $user = $entityManager->getRepository(\App\Entity\User::class)->find($value['id']);
            if ($user && !$entity->getUsers()->contains($user)) { // Verifica si ya está asociado
                $entity->addUser($user);
            }
        }

        foreach ($data["risks"] as $key => $value) {
            $risk = $entityManager->getRepository(\App\Entity\Riesgo\Riesgo::class)->find($value['id']);
            if ($risk) { // Verifica si ya está asociado
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
                    'impact'      => $risk->getImpact()  == null ? '' : $risk->getImpact()->getDescripcion(),
                    'frequency'   => $risk->getFrequency() == null ? '' : $risk->getFrequency()->getDescripcion(),
                ];
            }
            $result[] = [
                'id'          => $proceso->getId(),
                'code'          => $proceso->getCode(),
                'name'        => $proceso->getName(),
                'category'   => $proceso->getCategory(),
                'type'   => $proceso->getType(),
                'process'   => $proceso->getProcess(),
                'project'   =>  $proceso->getProject() ==null ? 0 : $proceso->getProject()->getId(),
                'unit'   => $proceso->getUnit(),
                'description' => $proceso->getDescription(),
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
                    'impact'      => $risk->getImpact()  == null ? '' : $risk->getImpact()->getDescripcion(),
                    'frequency'   => $risk->getFrequency() == null ? '' : $risk->getFrequency()->getDescripcion(),
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

    /**
     * Delete.
     */
    public function removeUserFromProceso($procesoId, $userId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $proceso= $em->getRepository(Proceso::class)->find($procesoId);
        $user = $em->getRepository(User::class)->find($userId);

        // Validar existencia
        if (!$proceso || !$user) {
            return [
                'success' => false,
                'message' => 'Proceso o responsable no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el usuario esté vinculado al proceso
        if (!$proceso->getUsers()->contains($user)) {
            return [
                'success' => false,
                'message' => 'El responsable no está asignado a este proceso.',
                'code' => 404
            ];
        }

        // Remover la relación
        $proceso->removeUser($user);
        $user->removeProceso($proceso);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }
}
