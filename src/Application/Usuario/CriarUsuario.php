<?php
declare(strict_types=1);

namespace Application\\Usuario;

use Domain\\Usuario\\Usuario;
use Domain\\Usuario\\UsuarioRepository;

class CriarUsuario
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(string $login, string $email, string $nome, string $senha): Usuario
    {
        $usuario = new Usuario(null, $login, $email, $nome, $senha);
        return $this->repository->save($usuario);
    }
}
