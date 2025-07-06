<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Evento;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\EventoRepository;
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

class EventoController extends AbstractController
{
    /**
    * @Route("/api/evento", methods={"POST"})
    * @OA\Post(
        * summary="Create Evento",
        * description="Create Evento",
        * operationId="createEvento",
        * tags={"Eventos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Evento",
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper, EventoRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
        * @Route("/api/evento/actualizar/{id}", methods={"PUT"})
        * @OA\Put(
        * summary="Put Evento",
        * description="Update Evento",
        * operationId="updateEvento",
        * tags={"Eventos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data Evento",
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
            $repository = $this->getDoctrine()->getRepository(Evento::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

   /**
    *  Get All Evento.
    * @Route("/api/evento", methods={"GET"})
    * @OA\Post(
        * summary="Eventos",
        * description="Lista todo",
        * operationId="AllEvento",
        * tags={"Eventos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta todos los eventos",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Eventos")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,EventoRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }


    /**
    *  Get Evento By Id.
    * @Route("/api/evento/{id}", methods={"GET"})
    * @OA\Post(
        * summary="Eventos",
        * description="Evento por Id",
        * operationId="EventoById",
        * tags={"Eventos"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Consulta de evento por Id",
        * ),
        * @OA\Response(
        *    response=422,
        *    description="Wrong credentials response",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
        *        )
        *     )
        * )
        * @OA\Tag(name="Eventos")
        * @Security(name="Bearer")
    */   
    public function findById($id,Request $request,EventoRepository $repository): JsonResponse
    {
        $data = $repository->getById($id);
        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/evento/{id}/remove-user/{userId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a user from a evento",
     *     tags={"Eventos"},
     *     @OA\Response(
     *         response=200,
     *         description="User removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User or Evento not found"
     *     )
     * )
     */
    public function removeUserFromEvent(
            int $id,
            int $userId,
            EventoRepository $repository
        ): JsonResponse {

        $result = $repository->removeUserFromEvent($id, $userId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }

    /**
     * @Route("/api/evento/{id}/remove-process/{processId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a process from a evento",
     *     tags={"Eventos"},
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
    public function removeProcessFromEvent(
            int $id,
            int $processId,
            EventoRepository $repository
        ): JsonResponse {

        $result = $repository->removeProcessFromEvent($id, $processId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }

    /**
     * @Route("/api/evento/{id}/remove-control/{controlId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a control from a evento",
     *     tags={"Eventos"},
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
    public function removeControlFromEvent(
            int $id,
            int $controlId,
            EventoRepository $repository
        ): JsonResponse {

        $result = $repository->removeControlFromEvent($id, $controlId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }

    /**
     * @Route("/api/evento/{id}/remove-risk/{riskId}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a risk from a evento",
     *     tags={"Eventos"},
     *     @OA\Response(
     *         response=200,
     *         description="Risk removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event or Risk not found"
     *     )
     * )
     */
    public function removeRiskFromEvent(
            int $id,
            int $riskId,
            EventoRepository $repository
        ): JsonResponse {

        $result = $repository->removeRiskFromEvent($id, $riskId);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }
}
