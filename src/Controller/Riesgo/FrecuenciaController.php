<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Frecuencia;
use App\Repository\Riesgo\FrecuenciaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


class FrecuenciaController extends AbstractController
{

    /**
    * @Route("/api/frecuencia", methods={"POST"})
    * @OA\Post(
        * summary="Create Frecuencia",
        * description="Create Frecuencia",
        * operationId="createFrecuencia",
        * tags={"Frecuencias"},
         * @OA\RequestBody(
        *    required=true,
        *    description="Data Proyecto",
        *    @OA\JsonContent(
        *       required={"description"},
        *       required={"peso"},
        *       required={"porcentaje"},
        *       @OA\Property(property="descripcion", type="string", example="Probable"),
        *       @OA\Property(property="peso", type="string", example="1"),
        *       @OA\Property(property="porcentaje", type="string", example="20")
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,FrecuenciaRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
    * @Route("/api/frecuencia/actualizar/{id}", methods={"PUT"})
    * @OA\Put(
        * summary="Put Frecuencia",
        * description="Update Frecuencia",
        * operationId="updateFrecuencia",
        * tags={"Frecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Proyecto",
        *    @OA\JsonContent(
        *       required={"description"},
        *       required={"peso"},
        *       required={"porcentaje"},
        *       @OA\Property(property="descripcion", type="string", example="Probable"),
        *       @OA\Property(property="peso", type="string", example="1"),
        *       @OA\Property(property="porcentaje", type="string", example="20")
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
            $repository = $this->getDoctrine()->getRepository(Frecuencia::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Frecuencia.
    * @Route("/api/frecuencia", methods={"GET"})
    * @OA\Post(
        * summary="Frecuencias",
        * description="Lista todo",
        * operationId="AllFrecuencia",
        * tags={"Frecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los frecuencia",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Frecuencias")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,FrecuenciaRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get Frecuencia By Id.
    * @Route("/api/frecuencia/{id}", methods={"GET"})
    * @OA\Post(
        * summary="Frecuencias",
        * description="Frecuencia por Id",
        * operationId="FrecuenciaById",
        * tags={"Frecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de frecuencia por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Frecuencias")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,FrecuenciaRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }


    /**
    * @Route("/api/Frecuencia/{id}", methods={"DELETE"})
    * @OA\Delete(
        * summary="Delete Frecuencia",
        * description="Delete Frecuencia",
        * operationId="deleteFrecuencia",
        * tags={"Frecuencias"},
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
    */
    public function delete($id,ValidatorInterface $validator,Helper $helper): Response
    {
        try {
            $em =$this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Frecuencia::class);
            return $repository->delete($id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

}
