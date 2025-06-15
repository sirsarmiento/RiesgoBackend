<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Control;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\Riesgo\ControlRepository;
use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Helper;
use Symfony\Component\Validator\Constraints\Json;

class ControlController extends AbstractController
{
    /**
    * @Route("/api/control", methods={"POST"})
    * @OA\Post(
        * summary="Create Control",
        * description="Create Control",
        * operationId="createControl",
        * tags={"Controls"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Control",
        *    @OA\JsonContent(
        *       required={"name"},
        *       required={"description"},
        *       @OA\Property(property="name", type="string", example="Analista"),
        *       @OA\Property(property="description", type="string", example="Analista")
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,ControlRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
    * @Route("/api/control/actualizar/{id}", methods={"PUT"})
    * @OA\Put(
        * summary="Put Control",
        * description="Update Control",
        * operationId="updateControl",
        * tags={"Controls"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Control",
        *    @OA\JsonContent(
        *       required={"nombre","description"},
        *       @OA\Property(property="name", type="string", format="string", example="Polar C.A Modificado"),
        *       @OA\Property(property="description", type="string", format="integer", example="1"),
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
            $repository = $this->getDoctrine()->getRepository(Control::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Control.
    * @Route("/api/control", methods={"GET"})
    * @OA\Post(
        * summary="Controls",
        * description="Lista todo",
        * operationId="AllControl",
        * tags={"Controls"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los control",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Controls")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,ControlRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get Control By Id.
    * @Route("/api/control/{id}", methods={"GET"})
    * @OA\Post(
        * summary="Controls",
        * description="Control por Id",
        * operationId="ControlById",
        * tags={"Controls"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de control por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Controls")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,ControlRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/control/{id}/remove-user/{userId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a user from a control",
     *     tags={"Controls"},
     *     @OA\Response(
     *         response=200,
     *         description="User removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User or Control not found"
     *     )
     * )
     */
    public function removeUserFromControl(
            int $id,
            int $userId,
            ControlRepository $repository
        ): JsonResponse {

        $result = $repository->removeUserFromControl($id, $userId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }
}
