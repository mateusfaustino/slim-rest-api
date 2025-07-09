<?php

declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\Usuario;

class UsuarioDTO
{
    public function __construct(
        public ?int $id,
        public string $login,
        public string $email,
        public string $nome
    ) {
    }

    public static function fromEntity(Usuario $usuario): self
    {
        return new self(
            $usuario->getId(),
            $usuario->getLogin(),
            $usuario->getEmail(),
            $usuario->getNome()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'email' => $this->email,
            'nome' => $this->nome,
        ];
    }
}
