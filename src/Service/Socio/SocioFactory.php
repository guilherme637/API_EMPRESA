<?php

namespace App\Service\Socio;

use App\Entity\Socio;
use Doctrine\Persistence\ObjectRepository;

class SocioFactory
{
    public function novoSocio(\stdClass $dados, ObjectRepository $empresa): Socio
    {
        $empresaDoSocio = $empresa->find($dados->empresa);

        $socio = new Socio;
        $socio
            ->setNomeSocio($dados->nome)
            ->setCpf($dados->cpf)
            ->setPosicao($dados->posicao)
            ->setEmpresa($empresaDoSocio);

        return $socio;
    }
}