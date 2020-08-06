<?php

namespace App\Validators;

class LoginValidator
{

    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
        'email'          => 'O campo :attribute deve conter um e-mail válido',
        'password'          => 'O campo :attribute é obrigatório',
    ];

    public const NEW_PACKAGE_RULE = [
        'email' => 'required | string | email | max:255',
        'password' => 'required | string | min:6 | confirmed',
    ];
}
