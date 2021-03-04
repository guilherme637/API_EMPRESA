<?php

namespace App\Controller;

use App\Repository\SocioRepository;
use App\Service\ExtratorDadosRequest;
use App\Service\Socio\SocioService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocioController extends BaseController
{
    public function __construct(
        SocioRepository $socioRepository,
        SocioService $socioService,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct($socioRepository, $socioService, $extratorDadosRequest);
    }

    /**
     * @Route ("/socio/empresa/{id}", methods={"GET"})
     */
    public function buscarPorSocio(int $id): Response
    {
        $socio = $this->repository->buscarEmpresa($id);
        $status = is_null($socio) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        return new JsonResponse($socio, $status);
    }
}