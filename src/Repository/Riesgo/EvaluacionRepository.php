<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Evaluacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;

/**
 * @method Evaluacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluacion[]    findAll()
 * @method Evaluacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Evaluacion::class);
    }

    /**
     * Create evaluacion.
     */
    public function post($data,$validator,$helper): JsonResponse  {

        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new Evaluacion(),$data);

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

            // Itera sobre los controles y asocia cada uno con la entidad Evaluacion
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
     * Update Evaluacion.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(Evaluacion::class)->find($id);
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

        // Itera sobre los controles y asocia cada uno con la entidad Evaluacion
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
        $evaluacions = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->leftJoin('p.riesgos', 'r')
            ->addSelect('u')
            ->addOrderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($evaluacions as $evaluacion) {
            $responsibles = [];
            $risks = [];
            $controls = [];
            foreach ($evaluacion->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($evaluacion->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'impact'        => $risk->getImpact()  == null ? 0 : $risk->getImpact()->getId(),
                    'impactName'        => $risk->getImpact()  == null ? '' : $risk->getImpact()->getDescripcion(),
                    'frecuency'        => $risk->getFrequency() == null ? 0 : $risk->getFrequency()->getId(),
                    'frequencyName'        => $risk->getFrequency() == null ? '' : $risk->getFrequency()->getDescripcion(),
                ];
            }
            foreach ($evaluacion->getControls() as $control) {
                $controls[] = [
                    'id'          => $control->getId(),
                    'name'        => $control->getName(),
                    'type'     => $control->getQualify(),
                    'executionType' => $control->getExecutionType(),
                ];
            }
            $result[] = [
                'id'          => $evaluacion->getId(),
                'name'        => $evaluacion->getName(),
                'description'   => $evaluacion->getDescription(),
                'type'   => $evaluacion->getType(),
                'startDate'   => $evaluacion->getStartDate(),
                'endDate'   => $evaluacion->getEndDate(),
                'responsibles' => $responsibles,
                'risks' => $risks,
                'controls' => $controls,
            ];
        }
        return $result;
    }

}
