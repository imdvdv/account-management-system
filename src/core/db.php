<?php

namespace core\db;

use PDO;
use PDOStatement;
use PDOException;
use core\helpers;
use core\response;

function get_pdo_instance(): ?PDO
{
    try {
        static $pdo;

        if ($pdo === null) {
            $pdo = new PDO('mysql:host=' . DB_SETTINGS['host'] . ';port=' . DB_SETTINGS['port'] . ';dbname=' . DB_SETTINGS['db_name'] . ';charset=' . DB_SETTINGS['charset'], DB_SETTINGS['username'], DB_SETTINGS['password'], DB_SETTINGS['options']);
        }

        return $pdo;
    } catch (PDOException $e) {
        helpers\write_to_log("DB Error: " . $e->getMessage(), __FILE__);
        response\redirect('/500');
        return null;
    }
}

function execute_query(string $query, array $params = []): PDOStatement|bool
{
    $pdo = get_pdo_instance();
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        helpers\write_to_log("DB Error: " . $e->getMessage(), __FILE__);
        helpers\abort('500');
    }
}

function get_last_id(): ?string
{
    $pdo = get_pdo_instance();
    try {
        $last_id = $pdo->lastInsertId();
        return is_string($last_id) ? $last_id : null;
    } catch (PDOException $e) {
        helpers\write_to_log("DB Error: " . $e->getMessage(), __FILE__);
        helpers\abort('500');
    }
}

function begin_transaction(): bool
{
    $pdo = get_pdo_instance();
    try {
        return $pdo->beginTransaction();
    } catch (PDOException $e) {
        helpers\write_to_log("DB Error: " . $e->getMessage(), __FILE__);
        helpers\abort('500');
    }
}

function commit(): bool
{
    $pdo = get_pdo_instance();
    try {
        return $pdo->commit();
    } catch (PDOException $e) {
        helpers\write_to_log("DB Error: " . $e->getMessage(), __FILE__);
        helpers\abort('500');
    }
}

function roll_back(): bool
{
    $pdo = get_pdo_instance();
    try {
        return $pdo->rollBack();
    } catch (PDOException $e) {
        helpers\write_to_log("Rollback failed: " . $e->getMessage(), __FILE__);
        helpers\abort('500');
    }
}
