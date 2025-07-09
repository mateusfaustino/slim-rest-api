<?php
declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\UsuarioRepository;
use Application\Usuario\UsuarioDTO;

class ListarUsuarios
{
    public function __construct(private UsuarioRepository $repository)
    {
    }

    /**
     * @return UsuarioDTO[]
     */
    public function execute(): array
    {
        $usuarios = $this->repository->findAll();
        return array_map(fn($u) => UsuarioDTO::fromEntity($u), $usuarios);
    }
}
