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
}
