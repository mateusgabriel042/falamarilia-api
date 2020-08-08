<?php

namespace App\Validators;

class NoticeValidator
{

    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
    ];

    public const NEW_PACKAGE_RULE = [
        'title' => 'required | string | max:80 | min:5',
        'description' => 'required | string | max:250 | min:20',
        'type' => 'required | string',
        'expired_at' => 'required',
    ];
}
