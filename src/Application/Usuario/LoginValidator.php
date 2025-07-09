<?php

declare(strict_types=1);

namespace Application\Usuario;

use Valitron\Validator;

class LoginValidator extends Validator
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->rule('required', ['login', 'senha']);
    }
}
