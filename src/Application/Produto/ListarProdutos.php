<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\ProdutoRepository;

class ListarProdutos
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    public function execute(): array
    {
        return $this->repository->findAll();
    }
}
