<?php

namespace App\Validators;

class ProfileValidator
{

    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'numeric'        => 'O valor do campo deve ser numérico',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
        'email'          => 'O campo :attribute deve conter um e-mail válido',
        'cpf'          => 'O campo :attribute deve ser um CPF válido',
        'cel_phone'          => 'O campo :attribute deve ser um celular válido',
        'genre'          => 'O campo :attribute deve ser um genêro válido (male|female|others)',
    ];

    public const NEW_PACKAGE_RULE = [
        'name'           => 'required | string | max:255',
        'email'          => 'required | max:100 | email',
        'type'           => 'integer',
        'password'       => 'required | string | min:6 | max:20 | confirmed',
        'genre'          => 'required | string',
        'phone'          => 'required | celPhone',
        'cpf'            => 'required | cpf',
    ];
}
