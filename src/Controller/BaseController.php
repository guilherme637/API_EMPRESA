<?php

namespace App\Controller;

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

    public function __construct(
        ObjectRepository $repository,
        ServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(): Response
    {
        $entidade = $this->repository->findAll();

        return new JsonResponse($entidade, Response::HTTP_OK);
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