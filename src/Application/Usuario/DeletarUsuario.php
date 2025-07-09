<?php
declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\UsuarioRepository;

class DeletarUsuario
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
