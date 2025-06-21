<?php

namespace App\Controller\Riesgo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Riesgo\ImpactoFrecuenciaRepository;
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

class ImpactoFrecuenciaController extends AbstractController
{
   /**
    *  Get All MapaCalor.
    * @Route("/api/mapacalor", methods={"GET"})
    * @OA\Post(
        * summary="ImpaMapaCalorctos",
        * description="Lista MapaCalor",
        * operationId="AllMapaCalor",
        * tags={"MapaCalor"},
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
        * @OA\Tag(name="MapaCalor")
        * @Security(name="Bearer")
    */   
    public function findAll(Request $request,ImpactoFrecuenciaRepository $repository): JsonResponse
    {
        $data = $repository->getall();
        return new JsonResponse($data, 200);
    }
}
