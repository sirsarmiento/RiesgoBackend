<?php

namespace App\Controller\Riesgo;

use App\Entity\Riesgo\Actividad;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\ActividadRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Helper;
use Symfony\Component\Validator\Csonstraints\Json;

class ActividadController extends AbstractController
{
    /**
    * @Route("/api/actividad", methods={"POST"})
    * @OA\Post(
        * summary="Create actividad",
        * description="Create actividad",
        * operationId="createactividad",
        * tags={"Actividad"},
        * @OA\RequestBody(
        *    required=true,
        *    description="Data actividad",
        *    @OA\JsonContent(
        *       required={"activity"},
        *       required={"done"},
        *       @OA\Property(property="activity", type="string", example="Analista"),
        *       @OA\Property(property="done", type="string", example=1)
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
    public function post(Request $request,ValidatorInterface $validator,Helper $helper,ActividadRepository $repository): JsonResponse
    {   
        try {
            $data = json_decode($request->getContent(),true);
            return $repository->post($data,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    
    /**
        * @Route("/api/actividad/actualizar/{id}", methods={"PUT"})
        * @OA\Put(
         * summary="Put actividad",
         * description="Update actividad",
         * operationId="updateactividad",
         * tags={"Actividad"},
         * @OA\RequestBody(
         *    required=true,
         *    description="Data actividad",
         *    @OA\JsonContent(
         *       required={"activity","done"},
         *       @OA\Property(property="activity", type="string", format="string", example="Polar C.A Modificado"),
         *       @OA\Property(property="done", type="string", format="integer", example=1),
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
            $repository = $this->getDoctrine()->getRepository(Actividad::class);
            return $repository->put($data,$id,$validator,$helper); 
        } catch (Exception $e) {
            return new JsonResponse(['msg'=>'Error del Servidor'],500);
        }
    }

    /**
     * @Route("/api/actividad/{id}", methods={"DELETE"})
     * @OA\Delete(
     *     summary="Remove a activity",
     *     tags={"Actividad"},
     *     @OA\Response(
     *         response=200,
     *         description="Activity removed successfully",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Activity not found"
     *     )
     * )
     */
    public function removeActivity(
            int $id,
            ActividadRepository $repository
        ): JsonResponse {

        $result = $repository->removeActivity($id);
        return new JsonResponse(['success' => $result['success']], $result['code']);
    }
}
