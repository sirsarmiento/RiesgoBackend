<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Control;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;


/**
 * @method Control|null find($id, $lockMode = null, $lockVersion = null)
 * @method Control|null findOneBy(array $criteria, array $orderBy = null)
 * @method Control[]    findAll()
 * @method Control[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControlRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Control::class);
    }

    /**
     * Create Control.
     */
    public function post($data,$validator,$helper): JsonResponse  {

        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new Control(),$data);

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
     * Update Control.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(Control::class)->find($id);
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
        $controls = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($controls as $control) {
            $responsibles = [];
            $risks = [];
            foreach ($control->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), 
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            foreach ($control->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'impacto'     => $risk->getImpact()  == null ? 0 : $risk->getImpact()->getId(),
                    'frecuencia'  => $risk->getFrequency() == null ? 0 : $risk->getFrequency()->getId(),
                ];
            }
            $result[] = [
                'id'          => $control->getId(),
                'name'        => $control->getName(),
                'qualify' => $control->getQualify(),
                'executionType' => $control->getExecutionType(),
                'isDocument' => $control->getIsDocument(),
                'isFrequent' => $control->getIsFrequent(),
                'hasEvidence' => $control->getHasEvidence(),
                'responsibleAssigned' => $control->getResponsibleAssigned(),
                'eventsAssociated' => $control->getEventsAssociated(),
                'isEffective' => $control->getIsEffective(),
                'isEvidenceEffective' => $control->getIsEvidenceEffective(),
                'correctTime' => $control->getCorrectTime(),
                'description' => $control->getDescription(),
                'responsibles' => $responsibles,
                'risks' => $risks,
            ];
        }
        return $result;
    }

}
