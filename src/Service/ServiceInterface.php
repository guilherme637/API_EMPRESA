<?php

namespace App\Service;

interface ServiceInterface
{
    public function criarEntidade(string $dados): void;

    public function atualizarEntidade(string $dados, int $id): int;

    public function removerEntidade(int $id): int;
}