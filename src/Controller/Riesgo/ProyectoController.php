<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Proyecto;
Use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\ProyectoRepository;
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

class ProyectoController extends AbstractController
{
    /**
    * @Route("/api/proyecto", methods={"POST"})
    * @OA\Post(
        * summary="Create Proyecto",
        * description="Create Proyecto",
        * operationId="createProyecto",
        * tags={"Proyectos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Proyecto",
        *    @OA\JsonContent(
        *       required={"nombre"},
        *       required={"descripcion"},
        *       @OA\Property(property="nombre", type="string", example="Analista"),
        *       @OA\Property(property="descripcion", type="string", example="Analista")
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,ProyectoRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    
    /**
        * @Route("/api/proyecto/actualizar/{id}", methods={"PUT"})
        * @OA\Put(
         * summary="Put Proyecto",
         * description="Update Proyecto",
         * operationId="updateProyecto",
         * tags={"Proyectos"},
         * @OA\RequestBody(
         *    required=true,
         *    description="Data Proyecto",
         *    @OA\JsonContent(
         *       required={"nombre","descripcion"},
         *       @OA\Property(property="nombre", type="string", format="string", example="Polar C.A Modificado"),
         *       @OA\Property(property="descripcion", type="string", format="integer", example="1"),
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
            $repository = $this->getDoctrine()->getRepository(Proyecto::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Proyecto.
    * @Route("/api/proyecto", methods={"GET"})
    * @OA\Post(
        * summary="Proyectos",
        * description="Lista todo",
        * operationId="AllProyecto",
        * tags={"Proyectos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los proyecto",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Proyectos")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,ProyectoRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get Proyecto By Id.
    * @Route("/api/proyecto/{id}", methods={"GET"})
    * @OA\Post(
        * summary="Proyectos",
        * description="Proyecto por Id",
        * operationId="ProyectoById",
        * tags={"Proyectos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de proyecto por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Proyectos")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,ProyectoRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/proyecto/{id}/remove-user/{userId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a user from a proyecto",
     *     tags={"Proyectos"},
     *     @OA\Response(
     *         response=200,
     *         description="User removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User or Proyecto not found"
     *     )
     * )
     */
    public function removeUserFromProyecto(
            int $id,
            int $userId,
            ProyectoRepository $repository
        ): JsonResponse {

        $result = $repository->removeUserFromProyecto($id, $userId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }
}
