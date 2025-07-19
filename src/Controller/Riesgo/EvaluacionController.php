<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Evaluacion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\EvaluacionRepository;
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

class EvaluacionController extends AbstractController
{
    /**
    * @Route("/api/evaluacion", methods={"POST"})
    * @OA\Post(
        * summary="Create Evaluacion",
        * description="Create Evaluacion",
        * operationId="createEvaluacion",
        * tags={"Evaluacion"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Evaluacion",
        *    @OA\JsonContent(
        *       required={"name", "description", "startDate", "endDate", "type"},
        *       @OA\Property(property="name", type="string", example="Evaluación de Desempeño"),
        *       @OA\Property(property="description", type="string", example="Evaluación anual de desempeño para el área de ventas"),
        *       @OA\Property(property="startDate", type="string", format="date", example="2025-01-01"),
        *       @OA\Property(property="endDate", type="string", format="date", example="2025-12-31"),
        *       @OA\Property(property="type", type="string", example="Por Riesgo")
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,EvaluacionRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
    * @Route("/api/evaluacion/actualizar/{id}", methods={"PUT"})
    * @OA\Put(
        * summary="Put evaluacion",
        * description="Update evaluacion",
        * operationId="updateevaluacion",
        * tags={"Evaluacion"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Evaluacion",
        *    @OA\JsonContent(
        *       required={"name", "description", "startDate", "endDate", "type"},
        *       @OA\Property(property="name", type="string", example="Evaluación de Desempeño"),
        *       @OA\Property(property="description", type="string", example="Evaluación anual de desempeño para el área de ventas"),
        *       @OA\Property(property="startDate", type="string", format="date", example="2025-01-01"),
        *       @OA\Property(property="endDate", type="string", format="date", example="2025-12-31"),
        *       @OA\Property(property="type", type="string", example="Por Riesgo")
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
            $repository = $this->getDoctrine()->getRepository(Evaluacion::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Evaluacion.
    * @Route("/api/evaluacion", methods={"GET"})
    * @OA\Post(
        * summary="Evaluacions",
        * description="Lista todo",
        * operationId="AllEvaluacion",
        * tags={"Evaluacions"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los evaluacion",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Evaluacion")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,EvaluacionRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }
}
