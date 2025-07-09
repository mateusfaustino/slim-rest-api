<?php
declare(strict_types=1);

namespace Application\\Usuario;

use Domain\\Usuario\\UsuarioRepository;

class AutenticarUsuario
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(string $login, string $senha): ?int
    {
        $usuario = $this->repository->findByLogin($login);
        if (!$usuario) {
            return null;
        }
        if (!password_verify($senha, $usuario->getSenha())) {
            return null;
        }
        return $usuario->getId();
    }
}
