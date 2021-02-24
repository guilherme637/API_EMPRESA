<?php

namespace App\Repository;

use App\Entity\Empresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmpresaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empresa::class);
    }

    public function savarEmpresa(Empresa $empresa): void
    {
        $this->getEntityManager()->persist($empresa);
        $this->getEntityManager()->flush();
    }

    public function listarTodasEmpresas():array
    {
        return $this->findAll();
    }

    public function buscarEmpresa(int $id): ?Empresa
    {
        return $this->find($id);
    }

    public function deletarEmpresa(Empresa $empresa): void
    {
        $this->getEntityManager()->remove($empresa);
        $this->getEntityManager()->flush();
    }

    public function atualiza(): void
    {
        $this->getEntityManager()->flush();
    }
}