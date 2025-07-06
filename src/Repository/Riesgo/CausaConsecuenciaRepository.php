<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\CausaConsecuencia;
use App\Entity\Riesgo\Riesgo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use App\Entity\Empresa;
Use App\Entity\User;

/**
 * @method CausaConsecuencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method CausaConsecuencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method CausaConsecuencia[]    findAll()
 * @method CausaConsecuencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CausaConsecuenciaRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, CausaConsecuencia::class);
    }

    /**
     * Create CausaConsecuencia.
     */
    public function post($data,$validator,$helper): JsonResponse  {

        $entityManager = $this->getEntityManager();
        $entity=$helper->setParametersToEntity(new CausaConsecuencia(),$data);

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
     * Update Causa.
     */
    public function put($data,$id,$validator,$helper): JsonResponse  
    {
        $entityManager = $this->getEntityManager();
        $entity =$entityManager->getRepository(CausaConsecuencia::class)->find($id);
        if (!$entity) {
            return new JsonResponse(['msg'=>'No existen Registros con el id: '.$id],404);  
        }
        $entity=$helper->setParametersToEntity($entity,$data);
        $currentUser =$entityManager->getRepository(User::class)->find($this->security->getUser()->getId());
        $entity->setUpdateBy($currentUser->getUserName());
        $entity->setUpdateAt(new \DateTime());


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
        $causes = $this->createQueryBuilder('p')
            ->leftJoin('p.riesgos', 'u')
            ->addSelect('u')
            ->addOrderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($causes as $cause) {
            $risks = [];
            foreach ($cause->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'impact'        => $risk->getImpact()  == null ? 0 : $risk->getImpact()->getId(),
                    'impactName'        => $risk->getImpact()  == null ? '' : $risk->getImpact()->getDescripcion(),
                    'frecuency'        => $risk->getFrequency() == null ? 0 : $risk->getFrequency()->getId(),
                    'frequencyName'        => $risk->getFrequency() == null ? '' : $risk->getFrequency()->getDescripcion(),
                ];
            }
            $result[] = [
                'id'          => $cause->getId(),
                'name'        => $cause->getName(),
                'type'       => $cause->getType(),
                'category'       => $cause->getCategory(),
                'description'       => $cause->getDescription(),
                'risks'      => $risks,
            ];
        }
        return $result;
    }

    public function getById($id): array
    {
        $entityManager = $this->getEntityManager();
        $causes = $this->createQueryBuilder('p')
            ->leftJoin('p.riesgos', 'u')
            ->addSelect('u')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($causes as $cause) {
            $risks = [];
            foreach ($cause->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'impact'        => $risk->getImpact()  == null ? 0 : $risk->getImpact()->getId(),
                    'impactName'        => $risk->getImpact()  == null ? '' : $risk->getImpact()->getDescripcion(),
                    'frecuency'        => $risk->getFrequency() == null ? 0 : $risk->getFrequency()->getId(),
                    'frequencyName'        => $risk->getFrequency() == null ? '' : $risk->getFrequency()->getDescripcion(),
                    'description' => $risk->getDescription(),
                ];
            }
            $result[] = [
                'id'          => $cause->getId(),
                'name'        => $cause->getName(),
                'type'       => $cause->getType(),
                'risks'      => $risks,
            ];
        }
        return $result;
    }

    
    /**
     * Delete.
     */
    public function removeRiesgoFromCausa($causaId, $riskId): array
    {
        $em = $this->getEntityManager();

        // Buscar las entidades por su ID
        $causa = $em->getRepository(CausaConsecuencia::class)->find($causaId);
        $riesgo = $em->getRepository(Riesgo::class)->find($riskId);

        // Validar existencia
        if (!$causa || !$riesgo) {
             return [
                'success' => false,
                'message' => 'Causa o riesgo no encontrado.',
                'code' => 404
            ];
        }

        // Validar que el riesgo esté vinculado a la causa
        if (!$causa->getRiesgos()->contains($riesgo)) {
            return [
                'success' => false,
                'message' => 'El riesgo no está asignado a esta causa.',
                'code' => 404
            ];
        }

        // Remover la relación
        $causa->removeRiesgo($riesgo);
        $riesgo->removeCausaConsecuencia($causa);

        $em->flush();

        return [
            'success' => true,
            'code' => 200
        ];
    }
}
