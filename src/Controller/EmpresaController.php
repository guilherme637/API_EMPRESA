<?php

namespace App\Controller;

use App\Repository\EmpresaRepository;
use App\Service\Empresa\EditarEmpresa;
use App\Service\Empresa\EmpresaFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpresaController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private EmpresaFactory $empresaFactory;
    private EmpresaRepository $empresaRepository;
    private EditarEmpresa $editarEmpresa;

    public function __construct(
        EntityManagerInterface $entityManager,
        EmpresaFactory $empresaFactory,
        EmpresaRepository $empresaRepository,
        EditarEmpresa $editarEmpresa
    ) {
        $this->entityManager = $entityManager;
        $this->empresaFactory = $empresaFactory;
        $this->empresaRepository = $empresaRepository;
        $this->editarEmpresa = $editarEmpresa;
    }

    /**
     * @Route ("/empresas", methods={"GET"})
     */
    public function index(): Response
    {
        $empresas = $this->empresaRepository->findAll();

        return new JsonResponse($empresas, Response::HTTP_OK);
    }

    /**
     * @Route ("/empresas", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $empresa = $this->empresaFactory->criarEmpresa($request->getContent());

        $this->entityManager->persist($empresa);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Criado com sucesso.'], Response::HTTP_CREATED);
    }

    /**
     * @Route ("/empresa/{id}", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $empresa = $this->empresaRepository->find($id);
        $status = is_null($empresa) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($empresa, $status);
    }

    /**
     * @Route ("/empresa/{id}/update", methods={"PUT"})
     */
    public function update(int $id, Request $request): Response
    {
        $novaEmpresa = $this->empresaFactory->criarEmpresa($request->getContent());
        $editarEmpresa = $this->editarEmpresa->editaEmpresa($this->empresaRepository, $novaEmpresa, $id);

        $this->entityManager->flush();

        return new Response('', $editarEmpresa);
    }

    /**
     * @Route ("/empresa/{id}/delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $empresa = $this->empresaRepository->find($id);

        $this->entityManager->remove($empresa);
        $this->entityManager->flush();

        $status = is_null($empresa) ? Response::HTTP_BAD_REQUEST : Response::HTTP_NO_CONTENT;

        return new Response('', $status);
    }
}