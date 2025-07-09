<?php

declare(strict_types=1);

namespace Domain\Produto;

interface ProdutoRepository
{
    public function save(Produto $produto): Produto;
    public function findAll(): array;
    public function findById(int $id): ?Produto;
    public function update(Produto $produto): bool;
    public function delete(int $id): bool;

    /**
     * @return array{items: Produto[], total: int}
     */
    public function search(
        int $page = 1,
        int $perPage = 10,
        ?string $term = null,
        ?string $name = null,
        ?float $minPrice = null,
        ?float $maxPrice = null
    ): array;
}
