<?php

namespace App\Service\Socio;

use App\Repository\EmpresaRepository;
use App\Repository\SocioRepository;
use App\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SocioService extends AbstractController implements ServiceInterface
{
    private SocioRepository $socioRepository;
    private SocioFactory $socioFactory;
    private EditarSocio $editarSocio;
    /**
     * @var EmpresaRepository
     */
    private EmpresaRepository $empresaRepository;

    public function __construct(
        SocioRepository $socioRepository,
        SocioFactory $socioFactory,
        EditarSocio $editarSocio,
        EmpresaRepository $empresaRepository
    ) {
        $this->socioRepository = $socioRepository;
        $this->socioFactory = $socioFactory;
        $this->editarSocio = $editarSocio;
        $this->empresaRepository = $empresaRepository;
    }

    public function criarEntidade(string $dados): void
    {
        $dadosJson = json_decode($dados);

        $socio = $this->socioFactory->novoSocio($dadosJson, $this->empresaRepository);

        $this->socioRepository->savarSocio($socio);
        $this->socioRepository->atualizar();
    }

    public function atualizarEntidade(string $dados, int $id): int
    {
        $dadosJson = json_decode($dados);

        $novoSocio = $this->socioFactory->novoSocio($dadosJson, $this->empresaRepository);
        $socioEditado = $this->editarSocio->editaSocio($this->socioRepository, $novoSocio, $id);

        $this->socioRepository->atualizar();

        return $socioEditado;
    }

    public function removerEntidade(int $id): int
    {
        $socio = $this->socioRepository->buscarSocio($id);

        if (is_null($socio)) {
            return Response::HTTP_NOT_FOUND;
        }

        $this->socioRepository->deletarSocio($socio);
        $this->socioRepository->atualizar();

        return Response::HTTP_NO_CONTENT;
    }
}