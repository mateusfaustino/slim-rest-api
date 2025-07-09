<?php

declare(strict_types=1);

namespace Application\Usuario;

class LoginDTO
{
    public function __construct(
        public string $login,
        public string $senha
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['login'],
            $data['senha']
        );
    }
}
