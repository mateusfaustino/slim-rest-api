<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\Produto;
use Domain\Produto\ProdutoRepository;

class CriarProduto
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    public function execute(string $nome, float $preco): Produto
    {
        $produto = new Produto(null, $nome, $preco);
        return $this->repository->save($produto);
    }
}
