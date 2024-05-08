<?php

function deleteUser (int $userID): void {
    $pdo = getPDO();
    $values = [$userID];

    // Delete data from the authorization tokens table for a given user ID
    $query = "DELETE FROM auth_tokens WHERE user_id = ?";
    executeQuery($pdo, $query, $values);

    // Delete data from the reset codes table for a given user ID
    $query = "DELETE FROM reset_codes WHERE user_id = ?";
    executeQuery($pdo, $query, $values);

    // Delete data from the users table for a given user ID
    $query = "DELETE FROM users WHERE id = ? LIMIT 1";
    executeQuery($pdo, $query, $values);
}