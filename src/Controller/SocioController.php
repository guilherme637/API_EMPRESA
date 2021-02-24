<?php

namespace App\Controller;

use App\Repository\EmpresaRepository;
use App\Repository\SocioRepository;
use App\Service\Socio\EditarSocio;
use App\Service\Socio\SocioFactory;
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

    public function __construct(
        EntityManagerInterface $entityManager,
        SocioRepository $socioRepository,
        SocioFactory $socioFactory,
        EditarSocio $editarSocio,
        EmpresaRepository $empresaRepository
    ) {
        $this->entityManager = $entityManager;
        $this->socioRepository = $socioRepository;
        $this->socioFactory = $socioFactory;
        $this->editarSocio = $editarSocio;
        $this->empresaRepository = $empresaRepository;
    }

    /**
     * @Route ("/socios", methods={"GET"})
     */
    public function index(): Response
    {
        $socios = $this->socioRepository->findAll();

        return new JsonResponse($socios, Response::HTTP_OK);
    }

    /**
     * @Route ("/socios", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $socio = $this->socioFactory->novoSocio($request->getContent(), $this->empresaRepository);

        $this->entityManager->persist($socio);
        $this->entityManager->flush();

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
        $novoSocio = $this->socioFactory->novoSocio($request->getContent(), $this->empresaRepository);
        $socioEditado = $this->editarSocio->editaSocio($this->socioRepository, $novoSocio, $id);

        $this->entityManager->flush();

        return new Response('', $socioEditado);
    }

    /**
     * @Route ("/socio/{id}/delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $socio = $this->socioRepository->find($id);

        $this->entityManager->remove($socio);
        $this->entityManager->flush();

        $status = is_null($socio) ? Response::HTTP_BAD_REQUEST : Response::HTTP_NO_CONTENT;

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