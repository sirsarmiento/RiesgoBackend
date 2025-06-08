<?php

namespace App\Controller\Riesgo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\ProcesoRepository;
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

class ProcesoController extends AbstractController
{
    /**
    * @Route("/api/proceso", methods={"POST"})
    * @OA\Post(
        * summary="Create Proceso",
        * description="Create Proceso",
        * operationId="createProceso",
        * tags={"Procesos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Proceso",
        *    @OA\JsonContent(
        *       required={"nombre"},
        *       required={"descripcion"},
        *       @OA\Property(property="name", type="string", example="Proceso de Analista"),
        *       @OA\Property(property="type", type="string", example="Id de tipo de proceso"),
        *       @OA\Property(property="category", type="string", example="Id de categoria"),
        *       @OA\Property(property="code", type="string", example="AB-1234"),
        *       @OA\Property(property="process", type="string", example="Id de proceso padre"),
        *       @OA\Property(property="project", type="string", example="Id de proceso"),
        *       @OA\Property(property="unit", type="string", example="Id de la unidad"),
        *       @OA\Property(property="description", type="string", example="Descripción del proceso"),
        *       @OA\Property(property="empresa", type="string", example="Id de la empresa"),
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,ProcesoRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
    * @Route("/api/proceso/actualizar/{id}", methods={"PUT"})
    * @OA\Put(
        * summary="Put proceso",
        * description="Update proceso",
        * operationId="updateproceso",
        * tags={"procesos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data proceso",
        *    @OA\JsonContent(
        *       required={"name"},
        *       required={"description"},
        *       @OA\Property(property="name", type="string", example="Proceso de Analista"),
        *       @OA\Property(property="type", type="string", example="Id de tipo de proceso"),
        *       @OA\Property(property="category", type="string", example="Id de categoria"),
        *       @OA\Property(property="code", type="string", example="AB-1234"),
        *       @OA\Property(property="process", type="string", example="Id de proceso padre"),
        *       @OA\Property(property="project", type="string", example="Id de proceso"),
        *       @OA\Property(property="unit", type="string", example="Id de la unidad"),
        *       @OA\Property(property="description", type="string", example="Descripción del proceso"),
        *       @OA\Property(property="empresa", type="string", example="Id de la empresa"),

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
            $repository = $this->getDoctrine()->getRepository(Proceso::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Proceso.
    * @Route("/api/proceso", methods={"GET"})
    * @OA\Post(
        * summary="Procesos",
        * description="Lista todo",
        * operationId="AllProceso",
        * tags={"Procesos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los proceso",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Procesos")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,ProcesoRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get Proceso By Id.
    * @Route("/api/proceso/{id}", methods={"GET"})
    * @OA\Post(
        * summary="Procesos",
        * description="Proceso por Id",
        * operationId="ProcesoById",
        * tags={"Procesos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de proceso por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Procesos")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,ProcesoRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }

}
