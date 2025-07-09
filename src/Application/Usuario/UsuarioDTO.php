<?php

declare(strict_types=1);

namespace Application\Usuario;

use Domain\Usuario\Usuario;
/**
 * @OA\Schema(
 *     schema="Usuario",
 *     required={"login","email","nome"}
 * )
 */

class UsuarioDTO
{
    public function __construct(
        /**
         * @OA\Property(example=1)
         */
        public ?int $id,
        /**
         * @OA\Property(example="johndoe")
         */
        public string $login,
        /**
         * @OA\Property(example="john@example.com")
         */
        public string $email,
        /**
         * @OA\Property(example="John Doe")
         */
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
