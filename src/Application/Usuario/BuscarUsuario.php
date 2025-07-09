<?php
declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\UsuarioRepository;
use Domain\Usuario\Usuario;

class BuscarUsuario
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(int $id): ?Usuario
    {
        return $this->repository->findById($id);
    }
}
