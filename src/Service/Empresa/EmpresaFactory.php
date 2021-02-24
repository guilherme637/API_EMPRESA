<?php

namespace App\Service\Empresa;

use App\Entity\Empresa;

class EmpresaFactory
{
    public function criarEmpresa(string $dados): Empresa
    {
        $dadosJson = json_decode($dados);

        $empresa = new Empresa();
        $empresa->setNomeEmpresa($dadosJson->nome);
        $empresa->setCnpj($dadosJson->cnpj);
        $empresa->setContato($dadosJson->contato);
        $empresa->setLocal($dadosJson->local);

        return $empresa;
    }
}