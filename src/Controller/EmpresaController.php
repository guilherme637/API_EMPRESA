<?php

namespace App\Controller;

use App\Repository\EmpresaRepository;
use App\Service\Empresa\EmpresaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpresaController extends AbstractController
{

    private EmpresaRepository $empresaRepository;
    private EmpresaService $empresaService;

    public function __construct(
        EmpresaRepository $empresaRepository,
        EmpresaService $empresaService
    ) {
        $this->empresaRepository = $empresaRepository;
        $this->empresaService = $empresaService;
    }

    /**
     * @Route ("/empresas", methods={"GET"})
     */
    public function index(): Response
    {
        $empresas = $this->empresaRepository->listarTodasEmpresas();

        return new JsonResponse($empresas, Response::HTTP_OK);
    }

    /**
     * @Route ("/empresas", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $this->empresaService->criarEmpresa($request->getContent());

        return new JsonResponse(['message' => 'Criado com sucesso.'], Response::HTTP_CREATED);
    }

    /**
     * @Route ("/empresa/{id}", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $empresa = $this->empresaRepository->buscarEmpresa($id);
        $status = is_null($empresa) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($empresa, $status);
    }

    /**
     * @Route ("/empresa/{id}/update", methods={"PUT"})
     */
    public function update(int $id, Request $request): Response
    {
        $empresaEditada = $this->empresaService->atualizarEmpresa($request->getContent(), $id);

        return new Response('', $empresaEditada);
    }

    /**
     * @Route ("/empresa/{id}/delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $status = $this->empresaService->removerEmpresa($id);

        return new Response('', $status);
    }
}