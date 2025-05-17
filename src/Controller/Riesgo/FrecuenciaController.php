<?php

namespace App\Controller\Riesgo;

use App\Entity\Frecuencia;
use App\Dto\FrecuenciaOutPutDto;
use App\Repository\FrecuenciaRepository;
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

    public function pagined(Request $request,FrecuenciaRepository $repository): JsonResponse
    {
        $param = json_decode($request->getContent(),true);

        $data = $repository
        ->findPagined($param);
        if (!$data) {
            return new JsonResponse(['msg'=>'No existen Registros'],200);  
        }   
         return new JsonResponse($data,200);  
    }


    /**
    * @Route("/api/Frecuencia/all", methods={"GET"})
    * @OA\Get(
        * summary="Frecuencia All",
        * description="Frecuencia All",
        * operationId="Frecuenciaall",
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
    public function findAll(Request $request,FrecuenciaRepository $repository): JsonResponse
    {
        $param = json_decode($request->getContent(),true);

        $data = $repository
        ->findAllPage($param);
        if (!$data) {
            return new JsonResponse(['msg'=>'No existen Registros'],200);  
        }   
         return new JsonResponse($data,200);  
    }


     /**
     *  Get list Frecuencias. 
     * @Route("/api/Frecuencia/list", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns Frecuencias",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=FrecuenciaOutPutDto::class))
     *     )
     * )
     * @OA\Tag(name="Frecuencias")
     * @Security(name="Bearer")
     */
    public function findList(Request $request,FrecuenciaRepository $repository): JsonResponse
    {
        $data = $repository
        ->findList();
        if (!$data) {
            return new JsonResponse(['msg'=>'No existen Registros'],200);  
        }   
         return new JsonResponse($data,200);  
    }
    
    /**
    * @Route("/api/Frecuencia", methods={"POST"})
    * @OA\Post(
        * summary="Create Frecuencia",
        * description="Create Frecuencia",
        * operationId="createFrecuencia",
        * tags={"Frecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Frecuencia",
        *    @OA\JsonContent(
        *       required={"descripcion"},
        *       @OA\Property(property="descripcion", type="string", example="Analista"),
        *       @OA\Property(property="nivel", type="integer", example="1")
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
    * @Route("/api/Frecuencia/{id}", methods={"PUT"})
    * @OA\Put(
        * summary="Actualiza Frecuencia",
        * description="ActualizaFrecuencia",
        * operationId="actualizafrecuencia",
        * tags={"Frecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Actualiza Frecuencia",
        *    @OA\JsonContent(
        *       required={"descripcion"},
        *       @OA\Property(property="descripcion", type="string", example="Analista"),
        *       @OA\Property(property="nivel", type="integer", example="1")
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
    public function put($id,Request $request,ValidatorInterface $validator,Helper $helper,FrecuenciaRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->put($data,$id,$validator,$helper);
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
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
