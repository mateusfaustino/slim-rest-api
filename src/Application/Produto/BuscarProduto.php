<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\Produto;
use Domain\Produto\ProdutoRepository;
use Application\Produto\ProdutoDTO;

class BuscarProduto
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    public function execute(int $id): ?ProdutoDTO
    {
        $produto = $this->repository->findById($id);
        return $produto ? ProdutoDTO::fromEntity($produto) : null;
    }
}
