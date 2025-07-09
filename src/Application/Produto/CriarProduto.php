<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\Produto;
use Domain\Produto\ProdutoRepository;
use Application\Produto\ProdutoDTO;

class CriarProduto
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    public function execute(string $nome, float $preco): ProdutoDTO
    {
        $produto = new Produto(null, $nome, $preco);
        $saved = $this->repository->save($produto);
        return ProdutoDTO::fromEntity($saved);
    }
}
