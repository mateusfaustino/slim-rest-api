<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\ProdutoRepository;
use Application\Produto\ProdutoListDTO;

class ListarProdutos
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    public function execute(
        int $page = 1,
        int $perPage = 10,
        ?string $term = null,
        ?string $name = null,
        ?float $minPrice = null,
        ?float $maxPrice = null
    ): ProdutoListDTO {
        $result = $this->repository->search($page, $perPage, $term, $name, $minPrice, $maxPrice);
        return ProdutoListDTO::fromResult($result, $page, $perPage);
    }
}
