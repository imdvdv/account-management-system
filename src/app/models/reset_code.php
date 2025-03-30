<?php

namespace app\models\reset_code;

use core\db;
use core\model;
use core\helpers;

const PARAMS_CONDITIONS = [
    'set' => [
        'uid' => 'user_id = :uid',
        'hash' => 'code_hash = :hash',
        'dte' => 'dt_exp = :dte'
    ]
];

function store(array $params): ?string
{
    $query = "INSERT INTO reset_codes (user_id, code_hash, dt_exp, client_ip)
    VALUES(:uid, :hash, :dte, :ip)";
    return model\add_row($query, $params);
}

function get_by_id(int $id): ?array
{
    $query = "SELECT * FROM reset_codes WHERE id = :id LIMIT 1";
    return model\find_one($query, ['id' => $id]);
}

function get_by_hash(string $hash): ?array
{
    $query = "SELECT * FROM reset_codes WHERE code_hash = :hash LIMIT 1";
    return model\find_one($query, ['hash' => $hash]);
}

function is_active(string $hash): bool
{
    $codeDb = get_by_hash($hash);
    return isset($codeDb['dt_exp']) && helpers\check_expiration_date($codeDb['dt_exp']);
}

function update_by_id(array $params): bool
{
    foreach (array_keys($params) as $key) {
        $set[] = PARAMS_CONDITIONS['set'][$key] ?? "$key = :$key";
    }

    $set = isset($set) && !empty($set) ? implode(', ', $set) : '';
    $query = "UPDATE reset_codes SET $set WHERE id = :id LIMIT 1";
    return model\update($query, $params);
}

function refresh_by_user_id(array $params): bool
{
    db\begin_transaction();
    remove_by_user_id($params['uid']);
    store($params);

    if (db\commit()) {
        return true;
    } else {
        db\roll_back();
        return false;
    }
}

function remove_by_id(int $id): bool
{
    $query = "DELETE FROM reset_codes WHERE id = :id LIMIT 1";
    return model\remove($query, ['id' => $id]);
}

function remove_by_user_id(string $userId): bool
{
    $query = "DELETE FROM reset_codes WHERE user_id = :uid";
    return model\remove($query, ['uid' => $userId]);
}