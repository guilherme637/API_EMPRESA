<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    private bool $sucesso;
    private $conteudo;
    private int $status;
    private ?int $paginaAtual;
    private ?int $qtdItens;

    public function __construct(
        bool $sucesso,
        $conteudo,
        int $status = Response::HTTP_OK,
        int $paginaAtual = null,
        int $qtdItens = null
    ) {
        $this->sucesso = $sucesso;
        $this->conteudo = $conteudo;
        $this->status = $status;
        $this->paginaAtual = $paginaAtual;
        $this->qtdItens = $qtdItens;
    }

    public function getResponse(): JsonResponse
    {
        $dados = [
            'success' => $this->sucesso,
            'results' => $this->conteudo,
            'page' => $this->paginaAtual,
            'totalItens' => $this->qtdItens,
        ];

        if (is_null($this->paginaAtual) || is_null($this->qtdItens)) {
            unset($dados['page']);
            unset($dados['totalItens']);
        }

        return new JsonResponse($dados, $this->status);
    }
}