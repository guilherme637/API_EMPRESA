<?php

namespace App\Repository;

use App\Entity\Socio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SocioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Socio::class);
    }

    public function savarSocio(Socio $empresa): void
    {
        $this->getEntityManager()->persist($empresa);
        $this->getEntityManager()->flush();
    }

    public function listarSocios():array
    {
        return $this->findAll();
    }

    public function buscarSocio(int $id): ?Socio
    {
        return $this->find($id);
    }

    public function deletarSocio(Socio $socio): void
    {
        $this->getEntityManager()->remove($socio);
        $this->getEntityManager()->flush();
    }

    public function buscarEmpresa(int $id): array
    {
        $empresa = $this->findBy([
            'empresa' => $id
        ]);

        return $empresa;
    }

    public function atualizar(): void
    {
        $this->getEntityManager()->flush();
    }
}