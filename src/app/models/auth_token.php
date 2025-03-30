<?php

namespace app\models\auth_token;

use core\model;
use core\helpers;

const PARAMS_CONDITIONS = [
    'set' => [
        'uid' => 'user_id = :uid',
        'hash' => 'token_hash = :hash',
        'dte' => 'dt_exp = :dte'
    ]
];

function store(array $params): ?string
{
    $query = "INSERT INTO auth_tokens (user_id, token_hash, dt_exp, client_ip)
    VALUES(:uid, :hash, :dte, :ip)";
    return model\add_row($query, $params);
}

function get_by_id(int $id): ?array
{
    $query = "SELECT * FROM auth_tokens WHERE id = :id LIMIT 1";
    $params = ['id' => $id];
    return model\find_one($query, $params);
}

function get_by_user_id(int $user_id): ?array
{
    $query = "SELECT * FROM auth_tokens WHERE user_id = :uid";
    $params = ['uid' => $user_id];
    return model\find_all($query, $params);
}

function get_by_hash(string $hash): ?array
{
    $query = "SELECT * FROM auth_tokens WHERE token_hash = :hash LIMIT 1";
    $params = ['hash' => $hash];
    return model\find_one($query, $params);
}

function is_active(string $hash): bool
{
    $token_db = get_by_hash($hash);
    return isset($token_db['dt_exp']) && helpers\check_expiration_date($token_db['dt_exp']);
}

function update_by_id(array $params): bool
{
    foreach (array_keys($params) as $key) {
        $set[] = PARAMS_CONDITIONS['set'][$key] ?? "$key = :$key";
    }

    $set = isset($set) && !empty($set) ? implode(', ', $set) : '';
    $query = "UPDATE auth_tokens SET $set WHERE id = :id LIMIT 1";
    return model\update($query, $params);
}

function extend_by_id(int $id, string $expiration_date): bool
{
    $query = "UPDATE auth_tokens SET dt_exp = :dte WHERE id = :id AND dt_exp != :dte LIMIT 1";
    return model\update($query, ['id' => $id, 'dte' => $expiration_date]);
}

function extend_by_hash(string $hash, string $expiration_date): bool
{
    $query = "UPDATE auth_tokens SET dt_exp = :dte WHERE token_hash = :hash AND dt_exp != :dte LIMIT 1";
    return model\update($query, ['hash' => $hash, 'dte' => $expiration_date]);
}

function remove_by_id(int $id): bool
{
    $query = "DELETE FROM auth_tokens WHERE id = :id LIMIT 1";
    return model\remove($query, ['id' => $id]);
}

function remove_by_user_id(string $user_id): bool
{
    $query = "DELETE FROM auth_tokens WHERE user_id = :uid";
    return model\remove($query, ['uid' => $user_id]);
}

function remove_by_hash(string $hash): bool
{
    $query = "DELETE FROM auth_tokens WHERE token_hash = :hash LIMIT 1";
    return model\remove($query, ['hash' => $hash]);
}