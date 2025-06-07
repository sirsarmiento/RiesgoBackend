<?php

namespace App\Repository\Riesgo;

use App\Entity\Riesgo\CausaConsecuencia;
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

            $entity->setCreateAt(new \DateTime());

            $entityManager->persist($entity);
            $entityManager->flush();

            return new JsonResponse(['msg'=>'Registro Creado','id'=>$entity->getId()],200);
        }
    }

    public function getAll(): array
    {
        $entityManager = $this->getEntityManager();
        $causes = $this->createQueryBuilder('p')
            ->leftJoin('p.riesgos', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($causes as $cause) {
            $risks = [];
            foreach ($cause->getRiesgos() as $risk) {
                $risks[] = [
                    'id'          => $risk->getId(),
                    'name'        => $risk->getName(),
                    'impacto'     => $risk->getImpacto(),
                    'frecuencia'  => $risk->getFrecuencia(),
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
}
