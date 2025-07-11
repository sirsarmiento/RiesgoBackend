<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Plan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\PlanRepository;
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

class PlanController extends AbstractController
{
    /**
    * @Route("/api/plan", methods={"POST"})
    * @OA\Post(
        * summary="Create Plan",
        * description="Create Plan",
        * operationId="createPlan",
        * tags={"Plans"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Plan",
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper, PlanRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
        * @Route("/api/plan/actualizar/{id}", methods={"PUT"})
        * @OA\Put(
        * summary="Put Plan",
        * description="Update Plan",
        * operationId="updatePlan",
        * tags={"Plans"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Plan",
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
    public function put($id,Request $request,ValidatorInterface $validator,Helper $helper): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(),true);
            $em =$this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Plan::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Plan.
    * @Route("/api/plan", methods={"GET"})
    * @OA\Post(
        * summary="Plans",
        * description="Lista todo",
        * operationId="AllPlan",
        * tags={"Plans"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los plans",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Plans")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,PlanRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get Plan By Id.
    * @Route("/api/plan/{id}", methods={"GET"})
    * @OA\Post(
        * summary="Plans",
        * description="Plan por Id",
        * operationId="PlanById",
        * tags={"Plans"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de plan por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Plans")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,PlanRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/plan/{id}/remove-user/{userId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a user from a plan",
     *     tags={"Plans"},
     *     @OA\Response(
     *         response=200,
     *         description="User removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User or Plan not found"
     *     )
     * )
     */
    public function removeUserFromPlan(
            int $id,
            int $userId,
            PlanRepository $repository
        ): JsonResponse {

        $result = $repository->removeUserFromPlan($id, $userId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }

    /**
     * @Route("/api/plan/{id}/remove-process/{processId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a process from a plan",
     *     tags={"Plans"},
     *     @OA\Response(
     *         response=200,
     *         description="User removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Process or Risk not found"
     *     )
     * )
     */
    public function removeProcessFromPlan(
            int $id,
            int $processId,
            PlanRepository $repository
        ): JsonResponse {

        $result = $repository->removeProcessFromPlan($id, $processId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }

    /**
     * @Route("/api/plan/{id}/remove-control/{controlId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a control from a plan",
     *     tags={"Plans"},
     *     @OA\Response(
     *         response=200,
     *         description="User removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Process or Risk not found"
     *     )
     * )
     */
    public function removeControlFromPlan(
            int $id,
            int $controlId,
            PlanRepository $repository
        ): JsonResponse {

        $result = $repository->removeControlFromPlan($id, $controlId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }

    /**
     * @Route("/api/plan/{id}/remove-risk/{riskId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a risk from a plan",
     *     tags={"Plans"},
     *     @OA\Response(
     *         response=200,
     *         description="Risk removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plan or Risk not found"
     *     )
     * )
     */
    public function removeRiskFromPlan(
            int $id,
            int $riskId,
            PlanRepository $repository
        ): JsonResponse {

        $result = $repository->removeRiskFromPlan($id, $riskId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }

    /**
     * @Route("/api/plan/{id}/remove-event/{eventId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a event from a plan",
     *     tags={"Plans"},
     *     @OA\Response(
     *         response=200,
     *         description="Cause removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plan or Event not found"
     *     )
     * )
     */
    public function removeEventFromPlan(
            int $id,
            int $eventId,
            PlanRepository $repository
        ): JsonResponse {

        $result = $repository->removeEventFromPlan($id, $eventId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }
}
