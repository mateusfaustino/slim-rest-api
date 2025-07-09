<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\Produto;

/**
 * @OA\Schema(
 *     schema="Produto",
 *     required={"nome","preco"}
 * )
 */
class ProdutoDTO
{
    public function __construct(
        /**
         * @OA\Property(example=1)
         */
        public ?int $id,
        /**
         * @OA\Property(example="Produto")
         */
        public string $nome,
        /**
         * @OA\Property(example=9.99)
         */
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
