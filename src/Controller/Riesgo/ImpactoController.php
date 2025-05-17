<?php

namespace App\Controller\Riesgo;

use App\Entity\Impacto;
use App\Dto\ImpactoOutPutDto;
use App\Repository\ImpactoRepository;
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


class ImpactoController extends AbstractController
{

    public function pagined(Request $request,ImpactoRepository $repository): JsonResponse
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
    * @Route("/api/Impacto/all", methods={"GET"})
    * @OA\Get(
        * summary="Impacto All",
        * description="Impacto All",
        * operationId="Impactoall",
        * tags={"Impactos"},
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
    */    
    public function findAll(Request $request,ImpactoRepository $repository): JsonResponse
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
     *  Get list Impactos. 
     * @Route("/api/Impacto/list", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns Impactos",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=ImpactoOutPutDto::class))
     *     )
     * )
     * @OA\Tag(name="Impactos")
     * @Security(name="Bearer")
     */
    public function findList(Request $request,ImpactoRepository $repository): JsonResponse
    {
        $data = $repository
        ->findList();
        if (!$data) {
            return new JsonResponse(['msg'=>'No existen Registros'],200);  
        }   
         return new JsonResponse($data,200);  
    }
    
    /**
    * @Route("/api/Impacto", methods={"POST"})
    * @OA\Post(
        * summary="Create Impacto",
        * description="Create Impacto",
        * operationId="createImpacto",
        * tags={"Impactos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Impacto",
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,ImpactoRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }


        
    /**
    * @Route("/api/Impacto/{id}", methods={"PUT"})
    * @OA\Put(
        * summary="Actualiza Impacto",
        * description="ActualizaImpacto",
        * operationId="actualizaimpacto",
        * tags={"Impactos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Actualiza Impacto",
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
    public function put($id,Request $request,ValidatorInterface $validator,Helper $helper,ImpactoRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->put($data,$id,$validator,$helper);
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }


    /**
    * @Route("/api/Impacto/{id}", methods={"DELETE"})
    * @OA\Delete(
        * summary="Delete Impacto",
        * description="Delete Impacto",
        * operationId="deleteImpacto",
        * tags={"Impactos"},
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
            $repository = $this->getDoctrine()->getRepository(Impacto::class);
            return $repository->delete($id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

}
