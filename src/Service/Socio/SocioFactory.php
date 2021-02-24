<?php

namespace App\Service\Socio;

use App\Entity\Socio;
use Doctrine\Persistence\ObjectRepository;

class SocioFactory
{
    public function novoSocio(string $dados, ObjectRepository $empresa): Socio
    {
        $dataJson = json_decode($dados);
        $empresaDoSocio = $empresa->find($dataJson->empresa);

        $socio = new Socio;
        $socio
            ->setNomeSocio($dataJson->nome)
            ->setCpf($dataJson->cpf)
            ->setPosicao($dataJson->posicao)
            ->setEmpresa($empresaDoSocio);

        return $socio;
    }
}