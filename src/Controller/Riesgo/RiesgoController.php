<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Riesgo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\RiesgoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Helper;
use Symfony\Component\Validator\Constraints\Json;

class RiesgoController extends AbstractController
{
    /**
    * @Route("/api/riesgo", methods={"POST"})
    * @OA\Post(
        * summary="Create Riesgo",
        * description="Create Riesgo",
        * operationId="createRiesgo",
        * tags={"Riesgos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Riesgo",
        *    @OA\JsonContent(
        *       required={"name"},
        *       required={"description"},
        *       @OA\Property(property="name", type="string", example="Analista"),
        *       @OA\Property(property="description", type="string", example="Analista")
        *    ),
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
    */
    public function post(Request $request,ValidatorInterface $validator,Helper $helper, RiesgoRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
        * @Route("/api/riesgo/actualizar/{id}", methods={"PUT"})
        * @OA\Put(
        * summary="Put Riesgo",
        * description="Update Riesgo",
        * operationId="updateRiesgo",
        * tags={"Riesgos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Riesgo",
        *    @OA\JsonContent(
        *       required={"name"},
        *       required={"description"},
        *       @OA\Property(property="name", type="string", example="Analista"),
        *       @OA\Property(property="description", type="string", example="Analista")
        *    ),
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
    */
    public function put($id,Request $request,ValidatorInterface $validator,Helper $helper): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(),true);
            $em =$this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Riesgo::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Riesgo.
    * @Route("/api/riesgo", methods={"GET"})
    * @OA\Post(
        * summary="Riesgos",
        * description="Lista todo",
        * operationId="AllRiesgo",
        * tags={"Riesgos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los riesgos",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Riesgos")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,RiesgoRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get Riesgo By Id.
    * @Route("/api/riesgo/{id}", methods={"GET"})
    * @OA\Post(
        * summary="Riesgos",
        * description="Riesgo por Id",
        * operationId="RiesgoById",
        * tags={"Riesgos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de riesgo por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Riesgos")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,RiesgoRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }

    /**
    *  Get All Riesgo para asociar a otros entidades.
    * @Route("/api/riesgoassociate", methods={"GET"})
    * @OA\Post(
        * summary="Riesgos",
        * description="Lista todo",
        * operationId="AllRiesgo",
        * tags={"Riesgos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los riesgos sin entidades relacionadadas",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Riesgos")
        * @Security(name="Bearer")
    */   
    public function findAllAssociate(Request $request,RiesgoRepository $repository): JsonResponse
    {
        $data = $repository->getAllForAssociate();
        return new JsonResponse($data, 200);
    }

}
