<?php

namespace App\Controller;

use App\Repository\EmpresaRepository;
use App\Service\Empresa\EmpresaService;

class EmpresaController extends BaseController
{
    public function __construct(
        EmpresaRepository $empresaRepository,
        EmpresaService $empresaService
    ) {
        parent::__construct($empresaRepository, $empresaService);
    }
}