<?php
declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\UsuarioRepository;

class ListarUsuarios
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    public function execute(): array
    {
        return $this->repository->findAll();
    }
}
