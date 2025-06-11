<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Impacto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\ImpactoRepository;
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

    /**
    * @Route("/api/impacto", methods={"POST"})
    * @OA\Post(
        * summary="Create Impacto",
        * description="Create Impacto",
        * operationId="createImpacto",
        * tags={"Impactos"},
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
    * @Route("/api/impacto/actualizar/{id}", methods={"PUT"})
    * @OA\Put(
        * summary="Put Impacto",
        * description="Update Impacto",
        * operationId="updateImpacto",
        * tags={"Impactos"},
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
            $repository = $this->getDoctrine()->getRepository(Impacto::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Impacto.
    * @Route("/api/impacto", methods={"GET"})
    * @OA\Post(
        * summary="Impactos",
        * description="Lista todo",
        * operationId="AllImpacto",
        * tags={"Impactos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los impacto",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Impactos")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,ImpactoRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get Impacto By Id.
    * @Route("/api/impacto/{id}", methods={"GET"})
    * @OA\Post(
        * summary="Impactos",
        * description="Impacto por Id",
        * operationId="ImpactoById",
        * tags={"Impactos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de impacto por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Impactos")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,ImpactoRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
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
