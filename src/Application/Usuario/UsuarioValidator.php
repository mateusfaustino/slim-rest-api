<?php

declare(strict_types=1);

namespace Application\Usuario;

use Valitron\Validator;

class UsuarioValidator extends Validator
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->rule('required', ['login', 'nome', 'email', 'senha']);
        $this->rule('lengthMin', 'login', 4);
        $this->rule('lengthMin', 'senha', 8);
        $this->rule('email', 'email');
    }
}
