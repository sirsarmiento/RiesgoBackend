<?php

namespace App\Controller\Riesgo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Riesgo\ParametrosControl;
use App\Repository\Riesgo\ParametrosControlRepository;
use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Helper;
use Symfony\Component\Validator\Constraints\Json;

class ParametrosControlController extends AbstractController
{
    /**
    * @Route("/api/parametroscontrol", methods={"POST"})
    * @OA\Post(
        * summary="Create parametroscontrol",
        * description="Create parametroscontrol",
        * operationId="createparametroscontrol",
        * tags={"ParametrosControl"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data parametroscontrol",
        *    @OA\JsonContent(
        *       required={"name"},
        *       required={"parama"},
        *       required={"paramb"},
        *       required={"paramc"},
        *       required={"module"},
        *       @OA\Property(property="name", type="string", example="Debil"),
        *       @OA\Property(property="parama", type="string", example="1"), 
        *       @OA\Property(property="paramb", type="string", example="50"),
        *       @OA\Property(property="paramc", type="string", example="blue"),
        *       @OA\Property(property="module", type="string", example="Solidez"),
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,ParametrosControlRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    
    /**
        * @Route("/api/parametroscontrol/actualizar/{id}", methods={"PUT"})
        * @OA\Put(
         * summary="Put parametroscontrol",
         * description="Update parametroscontrol",
         * operationId="updateparametroscontrol",
         * tags={"ParametrosControl"},
         * @OA\RequestBody(
         *    required=true,
         *    description="Data parametroscontrol",
         *    @OA\JsonContent(
         *       required={"name","parama","paramb","paramc", "module"},
         *       @OA\Property(property="name", type="string", format="string", example="Asignación de Pesos"),
         *       @OA\Property(property="parama", type="string", format="integer", example="50"),
         *       @OA\Property(property="paramb", type="string", format="integer", example="50"),
         *       @OA\Property(property="paramc", type="string", format="string", example="Blue"),
         *       @OA\Property(property="module", type="string", format="string", example="Pesos"),
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
            $repository = $this->getDoctrine()->getRepository(ParametrosControl::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All parametroscontrol.
    * @Route("/api/parametroscontrol", methods={"GET"})
    * @OA\Post(
        * summary="parametroscontrols",
        * description="Lista todo",
        * operationId="Allparametroscontrol",
        * tags={"ParametrosControl"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los parametroscontrol",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="ParametrosControl")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,ParametrosControlRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }
}
