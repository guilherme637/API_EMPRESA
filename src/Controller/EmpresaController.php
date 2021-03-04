<?php

namespace App\Controller;

use App\Repository\EmpresaRepository;
use App\Service\Empresa\EmpresaService;
use App\Service\ExtratorDadosRequest;

class EmpresaController extends BaseController
{
    public function __construct(
        EmpresaRepository $empresaRepository,
        EmpresaService $empresaService,
        ExtratorDadosRequest  $extratorDadosRequest
    ) {
        parent::__construct($empresaRepository, $empresaService, $extratorDadosRequest);
    }
}