<?php
declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\UsuarioRepository;

/**
 * Realiza a autenticação de usuário utilizando as credenciais informadas.
 */

class AutenticarUsuario
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(LoginDTO $login): ?int
    {
        $usuario = $this->repository->findByLogin($login->login);
        if (!$usuario) {
            return null;
        }
        if (!password_verify($login->senha, $usuario->getSenha())) {
            return null;
        }
        return $usuario->getId();
    }
}
