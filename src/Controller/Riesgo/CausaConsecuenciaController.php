<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\CausaConsecuencia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\CausaConsecuenciaRepository;
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

class CausaConsecuenciaController extends AbstractController
{
    /**
    * @Route("/api/causa", methods={"POST"})
    * @OA\Post(
        * summary="Create CausaConsecuencia",
        * description="Create CausaConsecuencia",
        * operationId="createCausaConsecuencia",
        * tags={"CausaConsecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data CausaConsecuencia",
        *    @OA\JsonContent(
        *       required={"name"},
        *       required={"description"},
        *       required={"type"},
        *       required={"category"},
        *       @OA\Property(property="name", type="string", example="Grieta en el techo"),
        *       @OA\Property(property="description", type="string", example="Impacto de piedra ocasiono la grieta en el techo"),
        *       @OA\Property(property="type", type="string", example="Causa"),
        *       @OA\Property(property="category", type="string", example="Infraestructura")
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,CausaConsecuenciaRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
    * @Route("/api/causa/actualizar/{id}", methods={"PUT"})
    * @OA\Put(
        * summary="Put Causa",
        * description="Update Causa",
        * operationId="updateCausa",
        * tags={"CausaConsecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Causas",
        *    @OA\JsonContent(
        *      required={"name"},
        *       required={"description"},
        *       required={"type"},
        *       required={"category"},
        *       @OA\Property(property="name", type="string", example="Grieta en el techo"),
        *       @OA\Property(property="description", type="string", example="Impacto de piedra ocasiono la grieta en el techo"),
        *       @OA\Property(property="type", type="string", example="Causa"),
        *       @OA\Property(property="category", type="string", example="Infraestructura")
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
            $repository = $this->getDoctrine()->getRepository(CausaConsecuencia::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All CausaConsecuencia.
    * @Route("/api/causa", methods={"GET"})
    * @OA\Post(
        * summary="CausaConsecuencias",
        * description="Lista todo",
        * operationId="AllCausaConsecuencia",
        * tags={"CausaConsecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los causa",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="CausaConsecuencias")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,CausaConsecuenciaRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get CausaConsecuencia By Id.
    * @Route("/api/causa/{id}", methods={"GET"})
    * @OA\Post(
        * summary="CausaConsecuencias",
        * description="CausaConsecuencia por Id",
        * operationId="CausaConsecuenciaById",
        * tags={"CausaConsecuencias"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de causa por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="CausaConsecuencias")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,CausaConsecuenciaRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }

    
    /**
    * @Route("/api/causa/{id}/riesgo/{riesgoId}", methods={"DELETE"})
    * @OA\Delete(
        * summary="Eliminar asociación entre Causa y Riesgo",
        * description="Elimina el vínculo entre una causa y un riesgo mediante sus IDs",
        * operationId="deleteCausaRiesgo",
        * tags={"CausaConsecuencias"},
        * @OA\Response(
        *    response=200,
        *    description="Asociación eliminada con éxito",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Asociación eliminada con éxito")
        *        )
        *     )
        * )
    */
    public function removeRiesgoFromCausa(
            int $id,
            int $riesgoId,
            CausaConsecuenciaRepository $repository
        ): JsonResponse {

        $result = $repository->removeRiesgoFromCausa($id, $riesgoId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }
}
