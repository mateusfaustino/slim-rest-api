<?php
declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\Usuario;
use Domain\Usuario\UsuarioRepository;
use Application\Usuario\UsuarioDTO;

class CriarUsuario
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(string $login, string $email, string $nome, string $senha): UsuarioDTO
    {
        $usuario = new Usuario(null, $login, $email, $nome, $senha);
        $saved = $this->repository->save($usuario);
        return UsuarioDTO::fromEntity($saved);
    }
}
