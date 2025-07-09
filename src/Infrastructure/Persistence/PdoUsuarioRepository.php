<?php
declare(strict_types=1);

namespace Infrastructure\\Persistence;

use Domain\\Usuario\\Usuario;
use Domain\\Usuario\\UsuarioRepository;
use PDO;

class PdoUsuarioRepository implements UsuarioRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function save(Usuario $usuario): Usuario
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (login, email, nome, senha) VALUES (:login, :email, :nome, :senha)');
        $stmt->execute([
            ':login' => $usuario->getLogin(),
            ':email' => $usuario->getEmail(),
            ':nome' => $usuario->getNome(),
            ':senha' => $usuario->getSenha(),
        ]);
        $usuario->setId((int)$this->pdo->lastInsertId());
        return $usuario;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT id, login, email, nome, senha FROM users');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Usuario((int)$row['id'], $row['login'], $row['email'], $row['nome'], $row['senha']), $rows);
    }

    public function findById(int $id): ?Usuario
    {
        $stmt = $this->pdo->prepare('SELECT id, login, email, nome, senha FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Usuario((int)$row['id'], $row['login'], $row['email'], $row['nome'], $row['senha']);
    }

    public function findByLogin(string $login): ?Usuario
    {
        $stmt = $this->pdo->prepare('SELECT id, login, email, nome, senha FROM users WHERE login = :login');
        $stmt->execute([':login' => $login]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Usuario((int)$row['id'], $row['login'], $row['email'], $row['nome'], $row['senha']);
    }

    public function update(Usuario $usuario): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET login = :login, email = :email, nome = :nome, senha = :senha WHERE id = :id');
        return $stmt->execute([
            ':id' => $usuario->getId(),
            ':login' => $usuario->getLogin(),
            ':email' => $usuario->getEmail(),
            ':nome' => $usuario->getNome(),
            ':senha' => $usuario->getSenha(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
