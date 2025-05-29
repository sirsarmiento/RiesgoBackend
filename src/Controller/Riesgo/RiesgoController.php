<?php
namespace App\Controller\Riesgo;

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
        *       required={"name", "impacto", "frecuencia", "affect", "description"},
        *       @OA\Property(property="name", type="string", example="Analista"),
        *       @OA\Property(property="impacto", type="integer", example=3),
        *       @OA\Property(property="frecuencia", type="integer", example=2),
        *       @OA\Property(property="description", type="string", example="Descripción del riesgo"),
        *       @OA\Property(property="affect", type="boolean", example=true),
        *       @OA\Property(
        *           property="procesos",
        *           type="array",
        *           @OA\Items(type="integer", example=1)
        *       ),
        *       @OA\Property(
        *           property="users",
        *           type="array",
        *           @OA\Items(type="integer", example=2)
        *       ),
        *       @OA\Property(
        *           property="causaConsecuencias",
        *           type="array",
        *           @OA\Items(type="integer", example=5)
        *       )
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,RiesgoRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
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
        *    description="Consulta todos los Riesgos",
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
        *    description="Consulta de Riesgo por Id",
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
    public function findById($id,Request $request, RiesgoRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }
}
