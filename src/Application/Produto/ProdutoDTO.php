<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\Produto;

class ProdutoDTO
{
    public function __construct(
        public ?int $id,
        public string $nome,
        public float $preco
    ) {
    }

    public static function fromEntity(Produto $produto): self
    {
        return new self(
            $produto->getId(),
            $produto->getNome(),
            $produto->getPreco()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'preco' => $this->preco,
        ];
    }
}
