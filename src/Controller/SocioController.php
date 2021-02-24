<?php

namespace App\Controller;

use App\Repository\EmpresaRepository;
use App\Repository\SocioRepository;
use App\Service\Socio\EditarSocio;
use App\Service\Socio\SocioFactory;
use App\Service\Socio\SocioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocioController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SocioRepository $socioRepository;
    private SocioFactory $socioFactory;
    private EditarSocio $editarSocio;
    private EmpresaRepository $empresaRepository;
    private SocioService $socioService;

    public function __construct(
        EntityManagerInterface $entityManager,
        SocioRepository $socioRepository,
        SocioFactory $socioFactory,
        EditarSocio $editarSocio,
        EmpresaRepository $empresaRepository,
        SocioService $socioService
    ) {
        $this->entityManager = $entityManager;
        $this->socioRepository = $socioRepository;
        $this->socioFactory = $socioFactory;
        $this->editarSocio = $editarSocio;
        $this->empresaRepository = $empresaRepository;
        $this->socioService = $socioService;
    }

    /**
     * @Route ("/socios", methods={"GET"})
     */
    public function index(): Response
    {
        $socios = $this->socioRepository->listarSocios();

        return new JsonResponse($socios, Response::HTTP_OK);
    }

    /**
     * @Route ("/socios", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $this->socioService->criarSocio($request->getContent());

        return new JsonResponse(['message' => 'Criado com sucesso.'], Response::HTTP_CREATED);
    }

    /**
     * @Route ("/socio/{id}", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $socio = $this->socioRepository->find($id);

        $status = is_null($socio) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($socio, $status);
    }

    /**
     * @Route ("/socio/{id}/update", methods={"PUT"})
     */
    public function update(Request $request, int $id): Response
    {
        $status = $this->socioService->atualizarSocio($id ,$request->getContent());

        return new Response('', $status);
    }

    /**
     * @Route ("/socio/{id}/delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $status = $this->socioService->removerSocio($id);

        return new Response('', $status);
    }

    /**
     * @Route ("/socio/empresa/{id}", methods={"GET"})
     */
    public function buscarPorSocio(int $id): Response
    {
        $socio = $this->socioRepository->buscarEmpresa($id);
        $status = is_null($socio) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK;

        return new JsonResponse($socio, $status);
    }
}