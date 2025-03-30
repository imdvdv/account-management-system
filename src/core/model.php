<?php

namespace core\model;

use core\db;

function add_row(string $query, array $params): ?string
{   
    if (str_starts_with($query, 'INSERT')) {
        db\execute_query($query, $params);
        return db\get_last_id();
    }
    return null;
}

function find_one(string $query, array $params): ?array 
{
    if (str_starts_with($query, 'SELECT')) {
        $stmt = db\execute_query($query, $params);
        $result = $stmt->fetch();
        return is_array($result) ? $result : null;
    } 
    return null; 
}

function find_all(string $query, array $params): ?array 
{
    if (str_starts_with($query, 'SELECT')) {
        $stmt = db\execute_query($query, $params);
        $result = $stmt->fetchAll();
        return is_array($result) ? $result : null;
    } 
    return null; 
}

function update(string $query, array $params): bool
{   
    if (str_starts_with($query, 'UPDATE')) {
        $stmt = db\execute_query($query, $params);
        return $stmt->rowCount() > 0 ? true : false;
    }
    return false;
}

function remove(string $query, array $params): bool
{
    if (str_starts_with($query, 'DELETE')) {
        $stmt = db\execute_query($query, $params); 
        return $stmt->rowCount() > 0 ? true : false;
    } 
    return false;
}