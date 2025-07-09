<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\ProdutoRepository;

class DeletarProduto
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
