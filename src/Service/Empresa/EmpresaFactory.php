<?php

namespace App\Service\Empresa;

use App\Entity\Empresa;

class EmpresaFactory
{
    public function criarEmpresa($dados): Empresa
    {
        $empresa = new Empresa();
        $empresa->setNomeEmpresa($dados->nome);
        $empresa->setCnpj($dados->cnpj);
        $empresa->setContato($dados->contato);
        $empresa->setLocal($dados->local);

        return $empresa;
    }
}