<?php
declare(strict_types=1);

namespace Domain\Usuario;

interface UsuarioRepository
{
    public function save(Usuario $usuario): Usuario;
    public function findAll(): array;
    public function findById(int $id): ?Usuario;
    public function findByLogin(string $login): ?Usuario;
    public function update(Usuario $usuario): bool;
    public function delete(int $id): bool;
}
