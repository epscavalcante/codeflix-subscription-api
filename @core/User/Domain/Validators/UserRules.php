<?php

namespace Core\User\Domain\Validators;

use Core\User\Domain\ValueObjects\Name;

class UserRules
{
    const RULES = [
        'userId' => [
            'required',
            'string',
            'uuid',
        ],
        'document' => [
            'required',
            'string',
            'min:11', // cpf
            'max:14', // cnpj
        ],
        'name' => [
            'required',
            'string',
            'min:'.Name::NAME_MIN_LENGTH,
            'max:'.Name::NAME_MAX_LENGTH,
        ],
        'email' => [
            'required',
            'email',
        ],
    ];
}
