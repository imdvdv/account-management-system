<?php

namespace app\models\user;

use core\model;
use core\validation;

const PARAMS_CONDITIONS = [
    'where' => [
        'name' => "(name = :name OR name LIKE CONCAT(:name, ' %') OR name LIKE CONCAT('% ', :name) OR name LIKE CONCAT('% ', :name, ' %'))",
    ],
    'set' => [
        'hash' => 'password_hash = :hash',
        'avatar' => 'avatar_path = :avatar'
    ]
];

const LABELS = [
    'form_signup' => ['name', 'email', 'password', 'confirm_password'],
    'form_login' => ['email', 'login_password', 'remember'],
    'form_email' => ['email'],
    'form_recovery' => ['password', 'confirm_password'],
    'form_profile' => ['name', 'email'],
    'form_avatar' => ['avatar'],
];

const VALIDATION_RULES = [
    'name' => [
        'required' => [
            'rule' => false,
        ],
        'pattern' => [
            'rule' => '/^([A-Za-z\s]{2,30}|[А-ЯЁа-яё\s]{2,30})$/',
            'error' => 'name must be at least 2 characters and contain only letters',
        ],
    ],
    'email' => [
        'required' => [
            'rule' => true,
        ],
        'pattern' => [
            'rule' => '/^[^ ]+@[^ ]+\.[a-z]{2,3}$/',
            'error' => 'enter a valid email address',
        ],
    ],
    'password' => [
        'required' => [
            'rule' => true,
        ],
        'pattern' => [
            'rule' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/',
            'error' => 'password must be at least 6 character with number, small and capital letter',
        ],
    ],
    'confirm_password' => [
        'required' => [
            'rule' => true,
        ],
        'pattern' => [
            'rule' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/',
            'error' => 'password must be at least 6 character with number, small and capital letter',
        ],
    ],
    'login_password' => [
        'required' => [
            'rule' => true,
        ],
    ],
    'remember' => [
        '"required' => [
            'rule' => false,
        ],
    ],
    'avatar' => [
        'required' => [
            'rule' => false,
            'error' => 'file is required',
        ],
        'extensions' => [
            'rule' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'],
        ],
        'max_size' => [
            'rule' => 1, // MB
        ],
    ],
];

function validate(array $fields, array $rules = VALIDATION_RULES): array
{
    return validation\validate_fields($fields, $rules);
}

function store(array $params): ?string
{
    $query = "INSERT INTO users (name, email, password_hash)
    VALUES(:name, :email, :hash)";
    return model\add_row($query, $params);
}

function get(array $params = []): ?array
{
    $limit = isset($params['id']) || isset($params['email']) ? 'LIMIT 1' : '';

    foreach (array_keys($params) as $key) {
        $where[] = PARAMS_CONDITIONS['where'][$key] ?? "$key = :$key";
    }

    $where = isset($where) && !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
    $query = "SELECT * FROM users {$where} {$limit}";
    return model\find_all($query, $params);
}

function get_by_id(int $id): ?array
{
    $query = "SELECT * FROM users WHERE id = :id";
    return model\find_one($query, ['id' => $id]);
}

function get_by_email(string $email): ?array
{
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
    return model\find_one($query, ['email' => $email]);
}

function get_by_name(string $name): ?array
{
    $query = "SELECT * FROM users WHERE" . PARAMS_CONDITIONS['where']['name'];
    return model\find_all($query, ['name' => $name]);
}

function update_by_id(array $params): bool
{
    foreach (array_keys($params) as $key) {
        $set[] = PARAMS_CONDITIONS['set'][$key] ?? "$key = :$key";
    }

    $set = isset($set) && !empty($set) ? implode(', ', $set) : '';
    $query = "UPDATE users SET $set WHERE id = :id";
    return model\update($query, $params);
}

function remove_by_id(int $id): bool
{
    $query = "DELETE FROM users WHERE id = :id";
    return model\remove($query, ['id' => $id]);
}