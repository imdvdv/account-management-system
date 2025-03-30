<?php

namespace core\validation;

function validate_fields(array $fields, array $rules): array 
{
    $errors = [];

    foreach ($fields as $key => $value) {

        if (array_key_exists($key, $rules)) {
            $is_empty_value = false;

            // Check field for empty
            if (is_string($value)) {
                $is_empty_value = empty($value);
            } elseif (is_array($value)) {
                $is_empty_value = isset($value['size']) && $value['size'] === 0; // file field
            }
            
            // Check require rule
            if (isset($rules[$key]['required']['rule']) && $rules[$key]['required']['rule'] && $is_empty_value) {
                $errors[$key] = $rules[$key]['required']['error'] ?? 'field is required';
            } elseif (!$is_empty_value) {

                // Check pattern rule
                if (isset($rules[$key]['pattern']['rule']) && !preg_match($rules[$key]['pattern']['rule'], $value)){
                    $errors[$key] = $rules[$key]['pattern']['error'] ?? 'invalid field value';
                }
                
                // File field validation rules
                if (isset($value['error']) && $value['error'] > 0) {
                    $errors[$key] = 'file upload error';
                } else {

                    // Check valid file extensions
                    if (isset($rules[$key]['extensions']['rule']) && !in_array($value["type"], $rules[$key]['extensions']['rule'])) {
                        $errors[$key] = $rules[$key]['extensions']['error'] ?? 'invalid file type';

                    // Check file max size    
                    } elseif (isset($rules[$key]['max_size']['rule']) && $rules[$key]['max_size']['rule'] < $value['size'] / 1000000) {
                        $errors[$key] = $rules[$key]['max_size']['error'] ?? "file should not exceed {$rules[$key]['max_size']['rule']} MB";
                    }

                }

            }

        } else {
            $errors[$key] = 'UNREGISTERED FIELD';
        }

    }
    return $errors;
}