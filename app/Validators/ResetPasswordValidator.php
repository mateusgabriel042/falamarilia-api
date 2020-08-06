<?php

namespace App\Validators;

class ResetPasswordValidator
{

    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'numeric'        => 'O valor do campo deve ser numérico',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
        'email'          => 'O campo :attribute deve conter um e-mail válido',
        'password'       => 'O campo :attribute é obrigatório',
    ];

    public const NEW_PACKAGE_RULE = [
        'email' => 'required | email',
        'password' => [
            'required',
            'min:6',
            'integer',
            'confirmed'
        ],
    ];
}
