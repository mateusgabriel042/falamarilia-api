<?php

namespace App\Validators;

class ServiceValidator
{

    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
        'regex'          => 'O campo :attribute deve ser uma cor hexadecimal',
    ];

    public const NEW_PACKAGE_RULE = [
        'name' => 'required | string',
        'color' => [
            'max:7',
            'min: 7',
            'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
        ],
        'icon' => 'required | string',
        'active' => 'required | integer | min:0 | max:1',
    ];
}
