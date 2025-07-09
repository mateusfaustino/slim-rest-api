<?php

declare(strict_types=1);

namespace Application\Produto;

use Domain\Produto\Produto;
use Domain\Produto\ProdutoRepository;

class AtualizarProduto
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    public function execute(int $id, string $nome, float $preco): ?Produto
    {
        $produto = $this->repository->findById($id);
        if (!$produto) {
            return null;
        }
        $produto->setNome($nome);
        $produto->setPreco($preco);
        $this->repository->update($produto);

        return $produto;
    }
}
