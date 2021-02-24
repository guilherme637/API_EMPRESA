<?php

namespace App\Service\Empresa;

use App\Entity\Empresa;
use App\Repository\EmpresaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class EmpresaService extends AbstractController
{
    private EmpresaRepository $empresaRepository;
    private EmpresaFactory $empresaFactory;
    private EditarEmpresa $editarEmpresa;

    public function __construct(
        EmpresaRepository $empresaRepository,
        EmpresaFactory $empresaFactory,
        EditarEmpresa $editarEmpresa
    ) {
        $this->empresaRepository = $empresaRepository;
        $this->empresaFactory = $empresaFactory;
        $this->editarEmpresa = $editarEmpresa;
    }

    public function criarEmpresa(string $dados): void
    {
        $dadosJson = json_decode($dados);

        $empresa = $this->empresaFactory->criarEmpresa($dadosJson);

        $this->empresaRepository->savarEmpresa($empresa);
    }

    public function atualizarEmpresa(string $dados, int $id): int
    {
        $dadosJson = json_decode($dados);

        $empresaNova = $this->empresaFactory->criarEmpresa($dadosJson);

        $empresaCriada = $this->editarEmpresa->editaEmpresa($this->empresaRepository, $empresaNova, $id);
        $this->empresaRepository->atualiza();

        return $empresaCriada;
    }

    public function removerEmpresa(int $id): int
    {
        $empresa = $this->empresaRepository->buscarEmpresa($id);

        if (is_null($empresa)) {
            return Response::HTTP_NOT_FOUND;
        }

        $this->empresaRepository->deletarEmpresa($empresa);
        $this->empresaRepository->atualiza();

        return Response::HTTP_NO_CONTENT;
    }
}