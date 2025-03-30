<?php

namespace core\controller;

use core\request;
use core\helpers;

function prepare_fields_data(array $labels): array
{   
    $attributes = [];
    $request_data = request\get_data();
    
    foreach ($labels as $field) {

        if (array_key_exists($field, $request_data)) {
            $attributes[$field] = is_string($request_data[$field]) ? helpers\remove_extra_spaces($request_data[$field]) : $request_data[$field];
        } else {
            $attributes[$field] = null;
        }
        
    }
    return $attributes;
}

function prepare_code_params(int $user_id, string $code, int $expiration_date): array
{
    return [
        'uid' => $user_id,
        'hash' => hash('sha256', $code),
        'dte' => helpers\get_formatted_date($expiration_date),
        'ip' => request\get_ip()
    ];
}