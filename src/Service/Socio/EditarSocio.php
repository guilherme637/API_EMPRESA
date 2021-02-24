<?php

namespace App\Service\Socio;

use App\Entity\Socio;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Response;

class EditarSocio
{
    public function editaSocio(ObjectRepository $repository, Socio $novoSocio, int $id): int
    {
        $socioExistente = $repository->find($id);

        if (is_null($socioExistente)) {
            return Response::HTTP_NO_CONTENT;
        }

        $socioExistente
            ->setNomeSocio($novoSocio->getNomeSocio())
            ->setCpf($novoSocio->getCpf())
            ->setPosicao($novoSocio->getPosicao())
            ->setEmpresa($novoSocio->getEmpresa());

        return 200;
    }
}