<?php

declare(strict_types=1);

namespace Infrastructure\Persistence;

use Domain\Produto\Produto;
use Domain\Produto\ProdutoRepository;
use PDO;

class PdoProdutoRepository implements ProdutoRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function save(Produto $produto): Produto
    {
        $stmt = $this->pdo->prepare('INSERT INTO products (nome, preco) VALUES (:nome, :preco)');
        $stmt->execute([
            ':nome' => $produto->getNome(),
            ':preco' => $produto->getPreco(),
        ]);
        $produto->setId((int) $this->pdo->lastInsertId());
        return $produto;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT id, nome, preco FROM products');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Produto((int)$row['id'], $row['nome'], (float)$row['preco']), $rows);
    }

    public function findById(int $id): ?Produto
    {
        $stmt = $this->pdo->prepare('SELECT id, nome, preco FROM products WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Produto((int)$row['id'], $row['nome'], (float)$row['preco']);
    }

    public function update(Produto $produto): bool
    {
        $stmt = $this->pdo->prepare('UPDATE products SET nome = :nome, preco = :preco WHERE id = :id');
        return $stmt->execute([
            ':id' => $produto->getId(),
            ':nome' => $produto->getNome(),
            ':preco' => $produto->getPreco(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
