<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\Produto;

class ProdutoListDTO
{
    /** @param ProdutoDTO[] $items */
    public function __construct(
        public int $total,
        public int $page,
        public int $perPage,
        public array $items
    ) {
    }

    public static function fromResult(array $result, int $page, int $perPage): self
    {
        $items = array_map(fn(Produto $p) => ProdutoDTO::fromEntity($p), $result['items']);
        return new self($result['total'], $page, $perPage, $items);
    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'page' => $this->page,
            'per_page' => $this->perPage,
            'items' => array_map(fn(ProdutoDTO $dto) => $dto->toArray(), $this->items),
        ];
    }
}
