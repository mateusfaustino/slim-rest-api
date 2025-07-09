<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\ProdutoRepository;

class ListarProdutos
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    /**
     * @return array{items: array, total: int}
     */
    public function execute(
        int $page = 1,
        int $perPage = 10,
        ?string $term = null,
        ?string $name = null,
        ?float $minPrice = null,
        ?float $maxPrice = null
    ): array {
        return $this->repository->search($page, $perPage, $term, $name, $minPrice, $maxPrice);
    }
}
