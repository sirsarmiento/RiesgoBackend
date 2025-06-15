<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\Proyecto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;

/**
 * @method Proyecto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proyecto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proyecto[]    findAll()
 * @method Proyecto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProyectoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Proyecto::class);
    }

    /**
     * Create Proyecto.
     */
    public function post($data,$validator,$helper): JsonResponse  {

        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new Proyecto(),$data);

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

            $entityManager->persist($entity);
            $entityManager->flush();

            return new JsonResponse(['msg'=>'Registro Creado','id'=>$entity->getId()],200);
        }    
    }

    /**
     * Update Proyecto.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(Proyecto::class)->find($id);
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
        $proyectos = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($proyectos as $proyecto) {
            $responsibles = [];
            foreach ($proyecto->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            $result[] = [
                'id'          => $proyecto->getId(),
                'name'        => $proyecto->getName(),
                'descripcion' => $proyecto->getDescripcion(),
                'responsibles' => $responsibles,
            ];
        }
        return $result;
    }

    public function getById($id): array
    {
        $entityManager = $this->getEntityManager();
        $proyectos = $this->createQueryBuilder('p')
            ->leftJoin('p.users', 'u')
            ->addSelect('u')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($proyectos as $proyecto) {
            $responsibles = [];
            foreach ($proyecto->getUsers() as $user) {
                $responsibles[] = [
                    'id'     => $user->getId(),
                    'fullName'   => $user->getPrimerNombre()." ".$user->getPrimerApellido(), // Asegúrate de tener este método en User
                    'dependence' => $user->getIdDependencia()->getDescripcion(), 
                    'position'   => $user->getIdCargo()->getDescripcion(),   
                ];
            }
            $result[] = [
                'id'          => $proyecto->getId(),
                'name'        => $proyecto->getName(),
                'descripcion' => $proyecto->getDescripcion(),
                'responsibles' => $responsibles,
            ];
        }
        return $result;
    }

    /**
     * Delete.
     */
    public function removeUserFromProyecto($proyectoId, $userId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $proyecto = $em->getRepository(Proyecto::class)->find($proyectoId);
        $user = $em->getRepository(User::class)->find($userId);

        // Validar existencia
        if (!$proyecto || !$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Proyecto o usuario no encontrado.'
            ], 404);
        }

        // Validar que el usuario esté vinculado al proyecto
        if (!$proyecto->getUsers()->contains($user)) {
            return new JsonResponse([
                'success' => false,
                'message' => 'El usuario no está asignado a este proyecto.'
            ], 404);
        }

        // Remover la relación
        $proyecto->removeUser($user);
        $user->removeProyecto($proyecto);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];

    }
}
