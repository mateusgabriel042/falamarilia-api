<?php

namespace App\Validators;

class CategoryValidator
{

    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
        'regex'          => 'O campo :attribute deve ser uma cor hexadecimal',
    ];

    public const NEW_PACKAGE_RULE = [
        'label' => 'required | string',
        'active' => 'required | integer | max:1 | min:0',
    ];
}
