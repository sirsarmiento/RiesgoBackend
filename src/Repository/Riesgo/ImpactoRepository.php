<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Impacto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;

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

    /**
     * Create Impacto.
     */
    public function post($data,$validator,$helper): JsonResponse  {

        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new Impacto(),$data);

        $errors = $validator->validate($entity);
        if($errors->count() > 0){
            $errorsString = (string) $errors;
            return new JsonResponse(['msg'=>$errorsString],500);
        }else{
            $currentUser =$entityManager->getRepository(User::class)->find($this->security->getUser()->getId());
            $entity->setCreateBy($currentUser->getUserName());
       
            $empresa= $entityManager->getRepository(Empresa::class)->find($this->security->getUser()->getIdempresa());
            
            if($empresa)
                $entity->setIdEmpresa($empresa);  

            $entityManager->persist($entity);
            $entityManager->flush();

            return new JsonResponse(['msg'=>'Registro Creado','id'=>$entity->getId()],200);
        }    
    }

    /**
     * Update Impacto.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(Impacto::class)->find($id);
        if (!$entity) {
            return new JsonResponse(['msg'=>'No existen Registros con el id: '.$id],404);  
        }
        $entity=$helper->setParametersToEntity($entity,$data);
        $currentUser =$entityManager->getRepository(User::class)->find($this->security->getUser()->getId());
        $entity->setUpdateBy($currentUser->getUserName());
        $entity->setUpdateAt(new \DateTime());

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
        $impactos = $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($impactos as $impacto) {
            $result[] = [
                'id'         => $impacto->getId(),
                'descripcion'=> $impacto->getDescripcion(),
                'peso'       => $impacto->getPeso(),
                'porcentaje' => $impacto->getPorcentaje()
            ];
        }
        return $result;
    }

    public function getById($id): array
    {
        $entityManager = $this->getEntityManager();
        $impactos = $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        $result = [];
           foreach ($impactos as $impacto) {
            $result[] = [
                'id'         => $impacto->getId(),
                'descripcion'=> $impacto->getDescripcion(),
                'peso'       => $impacto->getPeso(),
                'porcentaje' => $impacto->getPorcentaje()
            ];
        }
        return $result;
    }

}