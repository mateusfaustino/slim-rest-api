<?php
declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\UsuarioRepository;
use Domain\Usuario\Usuario;
use Application\Usuario\UsuarioDTO;

class BuscarUsuario
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(int $id): ?UsuarioDTO
    {
        $usuario = $this->repository->findById($id);
        return $usuario ? UsuarioDTO::fromEntity($usuario) : null;
    }
}
