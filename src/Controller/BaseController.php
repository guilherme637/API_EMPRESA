<?php

namespace App\Controller;

use App\Service\ExtratorDadosRequest;
use App\Service\ResponseFactory;
use App\Service\ServiceInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    protected ObjectRepository $repository;
    protected ServiceInterface $service;
    private ExtratorDadosRequest $extratorDadosRequest;

    public function __construct(
        ObjectRepository $repository,
        ServiceInterface $service,
        ExtratorDadosRequest $extratorDadosRequest,
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->extratorDadosRequest = $extratorDadosRequest;
    }

    public function index(Request $request): Response
    {
        $infoOrdernacao = $this->extratorDadosRequest->buscarDadosOrdernado($request);
        $infoFiltro = $this->extratorDadosRequest->buscarDadosFiltrado($request);
        [$paginaAtual, $itensPorPagiana] = $this->extratorDadosRequest->buscarDadosPorPagina($request);

        $entidade = $this->repository->findBy(
            $infoFiltro,
            $infoOrdernacao,
            $itensPorPagiana,
            ($paginaAtual - 1) * $itensPorPagiana
        );

        $responseFactory = new ResponseFactory(
            true,
            $entidade
        );

        return $responseFactory->getResponse();
    }

    public function store(Request $request): Response
    {
        $this->service->criarEntidade($request->getContent());

        return new JsonResponse(['message' => 'Criado com sucesso.'], Response::HTTP_CREATED);
    }

    public function show(int $id): Response
    {
        $empresa = $this->repository->find($id);
        $status = is_null($empresa) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($empresa, $status);
    }

    public function update(Request $request, int $id): Response
    {
        $status = $this->service->atualizarEntidade($request->getContent(), $id);

        return new Response('', $status);
    }

    public function delete(int $id): Response
    {
        $status = $this->service->removerEntidade($id);

        return new Response('', $status);
    }
}