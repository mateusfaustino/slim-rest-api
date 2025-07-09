<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\Produto;
use Domain\Produto\ProdutoRepository;

class BuscarProduto
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    public function execute(int $id): ?Produto
    {
        return $this->repository->findById($id);
    }
}
