<?php
declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\Usuario;
use Domain\Usuario\UsuarioRepository;
use Application\Usuario\UsuarioDTO;

class AtualizarUsuario
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(int $id, string $login, string $email, string $nome, string $senha): ?UsuarioDTO
    {
        $usuario = $this->repository->findById($id);
        if (!$usuario) {
            return null;
        }
        $usuario->setLogin($login);
        $usuario->setEmail($email);
        $usuario->setNome($nome);
        $usuario->setSenha($senha);
        $this->repository->update($usuario);
        return UsuarioDTO::fromEntity($usuario);
    }
}
