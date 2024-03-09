<?php

function getUser(int $userID): null|array {
    $pdo = getPDO();
    $query = "SELECT id, name, email, avatar_path FROM users WHERE id = ? LIMIT 1";
    $values = [$userID];
    $stmt = executeQueryDB($pdo, $query, $values);
    return $stmt->fetch();
}

