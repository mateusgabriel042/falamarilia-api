<?php

namespace App\Validators;

class SolicitationValidator
{

    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
    ];

    public const NEW_PACKAGE_RULE = [
        'service_id' => 'required | integer',
        'category_id' => 'required | integer',
        'user_id' => 'required | integer',
        'description' => 'required | string',
        'photo' => 'required',
        'geolocation' => 'required',
        'status' => 'required',
    ];
}
