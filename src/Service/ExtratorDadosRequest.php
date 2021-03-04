<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest
{
    private function buscarDadosRequest(Request $request)
    {
        $queryString= $request->query->all();
        $dadosOrdenacao = array_key_exists('sort', $queryString)
            ? $queryString['sort']
            : null;
        unset($queryString['sort']);

        $paginacao = array_key_exists('page',$queryString)
            ? $queryString['page']
            : 1;
        unset($queryString['page']);

        $itens = array_key_exists('itensPorPagina', $queryString)
            ? $queryString['itensPorPagina']
            : 5;
        unset($queryString['itensPorPagina']);

        return [$queryString, $dadosOrdenacao, $paginacao, $itens];
    }

    public function buscarDadosOrdernado(Request $request)
    {
        [, $ordenacao] = $this->buscarDadosRequest($request);

        return $ordenacao;
    }

    public function buscarDadosFiltrado(Request $request)
    {
        [$filtra,] = $this->buscarDadosRequest($request);

        return $filtra;
    }

    public function buscarDadosPorPagina(Request $request)
    {
        [, , $paginacao, $itens] = $this->buscarDadosRequest($request);

        return [$paginacao, $itens];
    }
}