<?php

namespace App\Service\Empresa;

use App\Entity\Empresa;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Response;

class EditarEmpresa
{
    public function editaEmpresa(ObjectRepository $repository, Empresa $novaEmpresa, int $id): int
    {
        $empresaExistente = $repository->find($id);

        if (is_null($empresaExistente)) {
            return Response::HTTP_NO_CONTENT;
        }

        $empresaExistente
            ->setNomeEmpresa($novaEmpresa->getNomeEmpresa())
            ->setCnpj($novaEmpresa->getCnpj())
            ->setContato($novaEmpresa->getContato())
            ->setLocal($novaEmpresa->getLocal());

        return 200;
    }
}